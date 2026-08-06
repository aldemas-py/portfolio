<?php

/**
 * Njenga Sam Portfolio - Admin Testimonials Management
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$db = getDB();
$message = '';
$messageType = '';

// Toggle approval
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $stmt = $db->prepare("UPDATE testimonials SET is_approved = 1 - is_approved WHERE id = ?");
    $stmt->execute([$id]);
    $message = 'Testimonial status updated.';
    $messageType = 'success';
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("SELECT image FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img) deleteImage($img);
    $stmt = $db->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $message = 'Testimonial deleted successfully.';
    $messageType = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_testimonial'])) {
    $id = (int)($_POST['testimonial_id'] ?? 0);
    $client_name = trim($_POST['client_name']);
    $client_role = trim($_POST['client_role']);
    $content = trim($_POST['content']);
    $rating = (int)($_POST['rating'] ?? 5);
    $is_approved = isset($_POST['is_approved']) ? 1 : 0;

    if ($client_name && $content) {
        try {
            $image = null;
            if ($id > 0) {
                $stmt = $db->prepare("SELECT image FROM testimonials WHERE id = ?");
                $stmt->execute([$id]);
                $existing_image = $stmt->fetchColumn();
                $image = uploadImage($_FILES['image'] ?? [], $existing_image);
            } else {
                $image = uploadImage($_FILES['image'] ?? []);
            }

            if ($id > 0) {
                $stmt = $db->prepare("UPDATE testimonials SET client_name=?, client_role=?, content=?, rating=?, image=?, is_approved=? WHERE id=?");
                $stmt->execute([$client_name, $client_role, $content, $rating, $image, $is_approved, $id]);
                $message = 'Testimonial updated.';
            } else {
                $stmt = $db->prepare("INSERT INTO testimonials (client_name, client_role, content, rating, image, is_approved) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$client_name, $client_role, $content, $rating, $image, $is_approved]);
                $message = 'Testimonial added.';
            }
            $messageType = 'success';
        } catch (Exception $e) {
            $message = $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = 'Client name and content are required.';
        $messageType = 'error';
    }
}

$testimonials = getAllTestimonials();
$editTestimonial = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editTestimonial = $stmt->fetch();
}

$activePage = 'testimonials';
$activeTitle = 'Manage Testimonials';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1><?php echo $editTestimonial ? 'Edit Testimonial' : 'Manage Testimonials'; ?></h1>
    <a href="?new=1" class="btn btn-accent btn-sm">+ Add Testimonial</a>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $messageType; ?>"><?php echo h($message); ?></div>
<?php endif; ?>

<?php if ($editTestimonial || isset($_GET['new'])): ?>
<div class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="testimonial_id" value="<?php echo $editTestimonial['id'] ?? 0; ?>">
        <div class="form-row">
            <div class="form-group">
                <label for="client_name">Client Name *</label>
                <input type="text" id="client_name" name="client_name" class="form-control" required
                    value="<?php echo h($editTestimonial['client_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="client_role">Client Role / Title</label>
                <input type="text" id="client_role" name="client_role" class="form-control"
                    value="<?php echo h($editTestimonial['client_role'] ?? ''); ?>"
                    placeholder="e.g., Founder, XYZ Ltd">
            </div>
        </div>
        <div class="form-group">
            <label for="rating">Rating (1-5)</label>
            <select id="rating" name="rating" class="form-control">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                <option value="<?php echo $i; ?>"
                    <?php echo ($editTestimonial['rating'] ?? 5) == $i ? 'selected' : ''; ?>>
                    <?php echo str_repeat('&#9733;', $i) . str_repeat('&#9734;', 5 - $i); ?>
                </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Client Photo / Avatar</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <?php if ($editTestimonial && $editTestimonial['image']): ?>
            <div style="margin-top:0.5rem;">
                <?php $tImg = testimonialImage($editTestimonial['image']); ?>
                <?php if ($tImg): ?>
                <img src="<?php echo h($tImg); ?>" class="preview-img" alt="Current photo"
                    style="width:60px;height:60px;border-radius:50%;object-fit:cover;">
                <?php endif; ?>
                <small style="color:var(--muted);"> Current photo. Upload new to replace.</small>
            </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="content">Testimonial Content *</label>
            <textarea id="content" name="content" class="form-control" rows="4"
                required><?php echo h($editTestimonial['content'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_approved" value="1"
                    <?php echo ($editTestimonial && $editTestimonial['is_approved']) ? 'checked' : ''; ?>>
                Approved (visible to visitors)
            </label>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" name="save_testimonial" class="btn btn-primary">Save Testimonial</button>
            <a href="<?php echo SITE_URL; ?>/admin/manage_testimonials.php" class="btn btn-accent">Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="table-container">
    <h3>All Testimonials</h3>
    <?php if (count($testimonials) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Client</th>
                <th>Role</th>
                <th>Rating</th>
                <th>Content</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($testimonials as $t): ?>
            <tr>
                <td>
                    <?php if ($t['image']): ?>
                    <?php $tImg = testimonialImage($t['image']); ?>
                    <?php if ($tImg): ?>
                    <img src="<?php echo h($tImg); ?>" class="preview-img" alt=""
                        style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                    <span style="color:var(--muted);">No img</span>
                    <?php endif; ?>
                    <?php else: ?>
                    <span style="color:var(--muted);">No img</span>
                    <?php endif; ?>
                </td>
                <td><strong><?php echo h($t['client_name']); ?></strong></td>
                <td><?php echo h($t['client_role'] ?? '-'); ?></td>
                <td><span style="color:var(--accent);"><?php echo str_repeat('&#9733;', $t['rating']); ?></span></td>
                <td style="max-width:280px;"><?php echo h(truncateText($t['content'], 80)); ?></td>
                <td><?php echo $t['is_approved'] ? '<span style="color:var(--success);">Approved</span>' : '<span style="color:var(--muted);">Pending</span>'; ?>
                </td>
                <td>
                    <a href="?toggle=<?php echo $t['id']; ?>" class="btn btn-sm btn-primary">
                        <?php echo $t['is_approved'] ? 'Unapprove' : 'Approve'; ?>
                    </a>
                    <a href="?edit=<?php echo $t['id']; ?>" class="btn btn-sm btn-accent">Edit</a>
                    <a href="?delete=<?php echo $t['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this testimonial?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="color:var(--muted);text-align:center;padding:2rem;">No testimonials yet.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
</content>