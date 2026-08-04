-- ============================================================
-- Migration 001: Add image column to testimonials
-- For existing databases (new installs use database.sql which
-- already includes the column).
-- Run against the production DB before/at deploy:
--   mysql -u USER -p portfolio_db < 001_add_testimonial_image.sql
-- ============================================================
ALTER TABLE testimonials
ADD COLUMN image VARCHAR(255) DEFAULT NULL
AFTER rating;