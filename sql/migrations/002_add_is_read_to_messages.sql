-- ============================================================
-- Migration 002: Add is_read column to messages table
-- Fixes blank admin dashboard page caused by
--   getDashboardStats() -> SELECT COUNT(*) FROM messages WHERE is_read = 0
-- which fails ("Unknown column 'is_read'") on databases created
-- before this column existed.
--
-- Run against the PRODUCTION database before/at deploy:
--   mysql -u USER -p portfolio_db < 002_add_is_read_to_messages.sql
-- ============================================================

ALTER TABLE messages
    ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0
    AFTER message;

