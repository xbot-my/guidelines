# Domain Naming Conventions

## 一、业务域命名空间铁律（最高优先级）

所有业务代码必须按 **业务域（Domain）** 作为第一级子目录，禁止扁平堆放。

### 映射对照表（强制执行）

| 功能层级 | 命名空间示例 | 物理路径示例 |
| :--- | :--- | :--- |
| **Models** | `App\Models\User\Profile` | `app/Models/User/Profile.php` |
| **Controllers** | `App\Http\Controllers\User\ProfileController` | `app/Http/Controllers/User/ProfileController.php` |
| **Form Requests** | `App\Http\Requests\User\UpdateProfileRequest` | `app/Http/Requests/User/UpdateProfileRequest.php` |
| **Resources** | `App\Http\Resources\User\ProfileResource` | `app/Http/Resources/User/ProfileResource.php` |
| **Services** | `App\Services\User\AccountService` | `app/Services/User/AccountService.php` |
| **Policies** | `App\Policies\User\ProfilePolicy` | `app/ Policies/User/ProfilePolicy.php` |
| **Jobs** | `App\Jobs\User\SendWelcomeEmail` | `app/Jobs/User/SendWelcomeEmail.php` |
| **Mail** | `App\Mail\User\WelcomeMail` | `app/Mail/User/WelcomeMail.php` |
| **Events** | `App\Events\User\Registered` | `app/Events/User/Registered.php` |
| **Listeners** | `App\Listeners\User\SendVerification` | `app/Listeners/User/SendVerification.php` |

## 二、命名约定（见名知意）

1. **类名后缀必须体现类型**：即使命名空间已含 `User`，类名仍需保留职责后缀（如 `ProfileController`、`AccountService`），便于在 IDE 中搜索。
2. **单数/复数**：业务域目录名统一用**单数**（`User`，而非 `Users`），符合 Laravel 模型默认规约。
3. **避免赘余**：命名空间已是 `User`，类名中不必再重复 `User`（例如 `UserProfileController` 应简写为 `ProfileController`），否则会变成 `User\UserProfileController`。

## 三、基础设施（保持扁平，不嵌套）

以下框架胶水代码**不用**按业务域嵌套，全局保持扁平：

- `database/migrations/`（文件名带时间戳已足够）
- `routes/web.php` 和 `routes/api.php`（路由用 `Route::prefix('user')->group()` 分组即可）
- `config/` 配置文件
- `lang/` 语言文件

## 四、AI 生成命令规范

执行 Artisan 命令时，必须连带子目录：

- `php artisan make:model User/Profile -m`（自动创建迁移，但迁移文件会放回扁平目录，可接受）
- `php artisan make:controller User/ProfileController --api`
- `php artisan make:request User/UpdateProfileRequest`
- `php artisan make:resource User/ProfileResource`
- `php artisan make:policy User/ProfilePolicy --model=User/Profile`

> 注：Laravel 不支持 `make:service`，新建 Service 时需手动创建目录和类文件。
