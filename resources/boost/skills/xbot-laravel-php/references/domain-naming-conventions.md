# Domain Naming Conventions

## 1. Domain Namespace Rule (Highest Priority)

All business code **must** use the **business domain** as its top-level subdirectory. Flat stacking is prohibited.

### Mapping Table (Mandatory)

| Layer | Namespace Example | Path Example |
| :--- | :--- | :--- |
| **Models** | `App\Models\User\Profile` | `app/Models/User/Profile.php` |
| **Controllers** | `App\Http\Controllers\User\ProfileController` | `app/Http/Controllers/User/ProfileController.php` |
| **Form Requests** | `App\Http\Requests\User\UpdateProfileRequest` | `app/Http/Requests/User/UpdateProfileRequest.php` |
| **Resources** | `App\Http\Resources\User\ProfileResource` | `app/Http/Resources/User/ProfileResource.php` |
| **Services** | `App\Services\User\AccountService` | `app/Services/User/AccountService.php` |
| **Policies** | `App\Policies\User\ProfilePolicy` | `app/Policies/User/ProfilePolicy.php` |
| **Jobs** | `App\Jobs\User\SendWelcomeEmail` | `app/Jobs/User/SendWelcomeEmail.php` |
| **Mail** | `App\Mail\User\WelcomeMail` | `app/Mail/User/WelcomeMail.php` |
| **Events** | `App\Events\User\Registered` | `app/Events/User/Registered.php` |
| **Listeners** | `App\Listeners\User\SendVerification` | `app/Listeners/User/SendVerification.php` |

## 2. Naming Conventions (Self-Documenting Names)

1. **Class name suffixes must reflect the type**: Even when the namespace already contains `User`, the class name must still retain its responsibility suffix (e.g. `ProfileController`, `AccountService`). This makes searching in an IDE easier.
2. **Singular / plural**: Business domain directories must use **singular** names (`User`, not `Users`), matching Laravel's default model convention.
3. **Avoid redundancy**: Since the namespace is already `User`, don't repeat `User` in the class name (e.g. `UserProfileController` should be shortened to `ProfileController`), otherwise you end up with `User\UserProfileController`.

## 3. Infrastructure (Keep Flat, Don't Nest)

The following framework glue code should **not** be nested by business domain. Keep everything flat globally:

- `database/migrations/` (timestamps in filenames are sufficient)
- `routes/web.php` and `routes/api.php` (use `Route::prefix('user')->group()` to organise routes)
- `config/` configuration files
- `lang/` language files

## 4. AI Artisan Command Conventions

When running Artisan commands, always include the subdirectory:

- `php artisan make:model User/Profile -m` (migration is created automatically, but placed in the flat directory — that's acceptable)
- `php artisan make:controller User/ProfileController --api`
- `php artisan make:request User/UpdateProfileRequest`
- `php artisan make:resource User/ProfileResource`
- `php artisan make:policy User/ProfilePolicy --model=User/Profile`

> Note: Laravel doesn't support `make:service`. When creating a new Service, create the directory and class file manually.
