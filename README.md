# Smart Aid System (updated, no homepage)

This package is wired to the `SmartAidSystem` MySQL database and its tables:
- `hospitals`
- `reminders`
- `requests`

## Setup
1. Import your `SmartAidSystem.sql` into MySQL.
2. Put this folder under your web root (e.g., `htdocs/Smart-Aid-System-main/`).
3. Edit `config/db.php` with your MySQL username/password if needed.
4. Open pages directly:
   - `/view/emergency.php`
   - `/view/reminder.php`
   - `/view/request.php`
