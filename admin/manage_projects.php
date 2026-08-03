<?php

/**
 * Njenga Sam Portfolio - Admin Projects Management
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$db = getDB();
$message = '';
$messageType = '';

// Handle Create/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_project'])) {
    $id = (int)($_POST['project_id'] ?? 0);
    $title = trim($_POST['title']);
    $slug = trim($_POST['slug']) ?: createSlug($title);
    $short_desc = trim($_POST['short_desc']);
    $full_desc = $_POST['full_desc'];
    $category = trim($_POST['category']);
    $url = trim($_POST['url']);
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    if ($title && $full_desc) {
        try {
            $image = null;
            if ($id > 0) {
                $stmt = $db->prepare("SELECT image FROM projects WHERE id = ?");
                $stmt->execute([$id]);
                $existing_image = $stmt->fetchColumn();
                $image = uploadImage($_FILES['image'] ?? [], $existing_image);
            } else {
                $image = uploadImage($_FILES['image'] ?? []);
            }

            if ($id > 0) {
                $stmt = $db->prepare("UPDATE projects SET title=?, slug=?, short_desc=?, full_desc=?, category=?, url=?, image=?, display_order=?, is_published=? WHERE id=?");
                $stmt->execute([$title, $slug, $short_desc, $full_desc, $category, $url, $image, $display_order, $is_published, $id]);
                $message = 'Project updated successfully.';
            } else {
                $stmt = $db->prepare("INSERT INTO projects (title, slug, short_desc, full_desc, category, url, image, display_order, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $slug, $short_desc, $full_desc, $category, $url, $image, $display_order, $is_published]);
                $message = 'Project created successfully.';
            }
            $messageType = 'success';
        } catch (Exception $e) {
            $message = $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = 'Title and full description are required.';
        $messageType = 'error';
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img) deleteImage($img);
    $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $message = 'Project deleted successfully.';
    $messageType = 'success';
}

// Get edit data
$editProject = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $editProject = $stmt->fetch();
}

$projects = getAllProjects();

$activePage = 'projects';
$activeTitle = 'Manage Projects';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1><?php echo $editProject ? 'Edit Project' : 'Manage Projects'; ?></h1>
    <a href="?new=1" class="btn btn-accent btn-sm">+ New Project</a>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $messageType; ?>"><?php echo h($message); ?></div>
<?php endif; ?>

<?php if ($editProject || isset($_GET['new'])): ?>
<div class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="project_id" value="<?php echo $editProject['id'] ?? 0; ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" class="form-control" required
                    value="<?php echo h($editProject['title'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" class="form-control"
                    value="<?php echo h($editProject['slug'] ?? ''); ?>"
                    placeholder="Leave blank to auto-generate from title">
                <small style="color:var(--muted);">Auto-generated from the title if left blank.</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" class="form-control"
                    value="<?php echo h($editProject['category'] ?? 'Web Development'); ?>">
            </div>
            <div class="form-group">
                <label for="display_order">Display Order</label>
                <input type="number" id="display_order" name="display_order" class="form-control"
                    value="<?php echo h($editProject['display_order'] ?? 0); ?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label for="url">Project URL (Live Website)</label>
            <input type="url" id="url" name="url" class="form-control"
                value="<?php echo h($editProject['url'] ?? ''); ?>"
                placeholder="https://example.com (leave blank if no live link yet)">
        </div>

        <div class="form-group">
            <label for="image">Project Image</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <?php if ($editProject && $editProject['image']): ?>
            <div style="margin-top:0.5rem;">
                <img src="<?php echo SITE_URL; ?>/uploads/<?php echo h($editProject['image']); ?>" class="preview-img"
                    alt="Current image">
                <small style="color:var(--muted);"> Current image. Upload new to replace.</small>
            </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="short_desc">Short Description (shown on card)</label>
            <textarea id="short_desc" name="short_desc" class="form-control"
                rows="2"><?php echo h($editProject['short_desc'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="full_desc">Full Description *</label>
            <textarea id="full_desc" name="full_desc" class="form-control" rows="8"
                style="font-family:monospace;"><?php echo h($editProject['full_desc'] ?? ''); ?></textarea>
            <small style="color:var(--muted);">Shown in the project detail modal. HTML supported.</small>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_published" value="1"
                    <?php echo ($editProject && $editProject['is_published']) ? 'checked' : ''; ?>>
                Publish (visible to visitors)
            </label>
        </div>

        <div style="display:flex;gap:1rem;">
            <button type="submit" name="save_project" class="btn btn-primary">Save Project</button>
            <a href="<?php echo SITE_URL; ?>/admin/manage_projects.php" class="btn btn-accent">Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="table-container">
    <h3>All Projects</h3>
    <?php if (count($projects) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Order</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td>
                    <?php if ($project['image']): ?>
                    <img src="<?php echo SITE_URL; ?>/uploads/<?php echo h($project['image']); ?>" class="preview-img"
                        alt="">
                    <?php else: ?>
                    <span style="color:var(--muted);">No img</span>
                    <?php endif; ?>
                </td>
                <td><strong><?php echo h($project['title']); ?></strong></td>
                <td><?php echo h($project['category']); ?></td>
                <td><?php echo $project['is_published'] ? '<span style="color:var(--success);">Published</span>' : '<span style="color:var(--muted);">Draft</span>'; ?>
                </td>
                <td><?php echo h($project['display_order']); ?></td>
                <td><small><?php echo formatDate($project['created_at']); ?></small></td>
                <td>
                    <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="?delete=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this project?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="color:var(--muted);text-align:center;padding:2rem;">No projects created yet. Click "+ New Project" to get
        started.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
</content>