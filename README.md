# LockUnlocker

**LockUnlocker** is a simple and extendable Laravel package to manage locking and unlocking records of any model, with full logging support.

## 📦 Installation

### 1. Add repository to your `composer.json` (if installing from GitHub):

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/FereshtehAminikhoo/lock-unlocker"
    }
]
```

Then require the package:

```bash
composer require fereshtehaminikhoo/lock-unlocker
```

---

### 2. Publish config and migration files:

```bash
php artisan vendor:publish --tag=lock-unlocker-config
php artisan vendor:publish --tag=lock-unlocker-migrations
```

---

### 3. Run migrations:

```bash
php artisan migrate
```

---

## ⚙️ Configuration

Set default lock time in .env:

```env
LOCK_UNLOCKER_TIME="+2 hours"
```

---

## 🛠️ Usage

Add the trait to your model:

```php
use LockUnlocker\Traits\Lockable;

class Order extends Model
{
    use Lockable;
}
```

---

## 🔐 Locking & Unlocking

```php
use LockUnlocker\Classes\Lock;
use LockUnlocker\Classes\Unlock;

Lock::applyLock(Order::class, $orderId, 'user', auth()->id());
Unlock::releaseLock(Order::class, $orderId, 'user', auth()->id());
```

### ✅ Filter unlocked models

```php
Order::withCheck()->get();
```

### 📄 Lock info for a record

```php
$order = Order::withLockInfo()->find($orderId);
$lockData = $order->lockInfo;
```

---

## 🗃️ Tables

### lock_unlockers

- `id`
- `model_name`, `model_id`
- `is_lock`, `lock_expired_at`
- `creator_name`, `creator_id`
- `timestamps`

### lock_unlocker_logs

- `id`
- `lock_unlocker_id`
- `model_name`, `model_id`
- `action` (lock/unlock)
- `is_lock`, `lock_expired_at`
- `creator_name`, `creator_id`
- `timestamps`

---
