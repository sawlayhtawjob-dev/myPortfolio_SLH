<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';


/*
|--------------------------------------------------------------------------
| Already Authenticated
|--------------------------------------------------------------------------
*/

if (is_admin()) {
    redirect('admin/index.php');
}


/*
|--------------------------------------------------------------------------
| Login State
|--------------------------------------------------------------------------
*/

$error = '';

$username = '';

$loginAttempts = (int) ($_SESSION['login_attempts'] ?? 0);
$lastAttemptAt = (int) ($_SESSION['last_login_attempt'] ?? 0);


/*
|--------------------------------------------------------------------------
| Login Rate Limit
|--------------------------------------------------------------------------
|
| Local:
|   5 failed attempts within 15 minutes.
|
| This is a lightweight session-based protection.
| A server/database based limiter can be added later if needed.
|
*/

$maxAttempts = 5;
$lockoutSeconds = 15 * 60;


/*
|--------------------------------------------------------------------------
| POST Login
|--------------------------------------------------------------------------
*/

if (is_post()) {

    try {

        verify_csrf();

        /*
        | Rate limit check
        */

        if (
            $loginAttempts >= $maxAttempts
            && $lastAttemptAt > 0
            && (time() - $lastAttemptAt) < $lockoutSeconds
        ) {
            $error = 'Too many login attempts. Please try again later.';
        } else {

            /*
            | Reset expired lockout window
            */

            if (
                $lastAttemptAt > 0
                && (time() - $lastAttemptAt) >= $lockoutSeconds
            ) {
                $loginAttempts = 0;

                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_login_attempt'] = 0;
            }


            /*
            | Read input
            */

            $username = clean_string(
                post('username'),
                100
            );

            $password = (string) post('password');


            /*
            | Validate input
            */

            if ($username === '' || $password === '') {

                $error = 'Please enter username and password.';

            } elseif (mb_strlen($username) > 100) {

                $error = 'Invalid username or password.';

            } elseif (mb_strlen($password) > 255) {

                $error = 'Invalid username or password.';

            } else {

                /*
                | Find admin account
                */

                $admin = db_one(
                    "SELECT id, username, password_hash
                     FROM admins
                     WHERE username = ?
                     LIMIT 1",
                    [$username]
                );


                /*
                | Verify password
                */

                if (
                    $admin !== null
                    && isset(
                        $admin['id'],
                        $admin['username'],
                        $admin['password_hash']
                    )
                    && is_string($admin['password_hash'])
                    && password_verify(
                        $password,
                        $admin['password_hash']
                    )
                ) {

                    /*
                    | Successful authentication
                    */

                    login_admin(
                        (int) $admin['id']
                    );

                    $_SESSION['admin_username'] =
                        (string) $admin['username'];


                    /*
                    | Reset failed attempts
                    */

                    unset(
                        $_SESSION['login_attempts'],
                        $_SESSION['last_login_attempt']
                    );


                    redirect('admin/index.php');

                } else {

                    /*
                    | Failed authentication
                    */

                    $loginAttempts++;

                    $_SESSION['login_attempts'] =
                        $loginAttempts;

                    $_SESSION['last_login_attempt'] =
                        time();


                    /*
                    | Generic error message.
                    | Never reveal whether username exists.
                    */

                    $error =
                        'Invalid username or password.';
                }
            }
        }

    } catch (Throwable $e) {

        /*
        |--------------------------------------------------------------------------
        | Log unexpected authentication errors
        |--------------------------------------------------------------------------
        */

        error_log(
            'Admin login error: ' . $e->getMessage()
        );


        /*
        | Never expose exception details to visitors.
        */

        $error =
            'Unable to process login right now. Please try again.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex, nofollow, noarchive"
    >

    <link
        rel="icon"
        type="image/svg+xml"
        href="../assets/images/favicon.svg"
    >

    <title>Admin Login — SAWLAYHTAW</title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family:
                Inter,
                Arial,
                sans-serif;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(183, 255, 60, .10),
                    transparent 35%
                ),
                #090909;

            color: #fff;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 42px;

            background: #111;

            border: 1px solid
                rgba(255,255,255,.10);

            border-radius: 24px;

            box-shadow:
                0 30px 80px
                rgba(0,0,0,.45);
        }

        .admin-brand {
            display: inline-flex;
            margin-bottom: 24px;

            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.04em;
        }

        .admin-brand span {
            color: #b7ff3c;
        }

        h1 {
            margin: 0 0 8px;

            font-size: 32px;
            letter-spacing: -.04em;
        }

        .subtitle {
            margin: 0 0 30px;

            color: #888;
            font-size: 14px;
        }

        .alert {
            margin-bottom: 20px;
            padding: 13px 15px;

            border-radius: 10px;

            font-size: 13px;

            background:
                rgba(255,70,70,.10);

            border: 1px solid
                rgba(255,70,70,.25);

            color: #ff8585;
        }

        label {
            display: block;
            margin-bottom: 8px;

            font-size: 13px;
            font-weight: 600;

            color: #aaa;
        }

        input {
            width: 100%;
            height: 50px;

            margin-bottom: 18px;
            padding: 0 15px;

            border: 1px solid
                rgba(255,255,255,.12);

            border-radius: 10px;

            outline: none;

            background: #181818;
            color: #fff;

            font-size: 14px;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        input:focus {
            border-color: #b7ff3c;

            box-shadow:
                0 0 0 3px
                rgba(183,255,60,.08);
        }

        button {
            width: 100%;
            height: 52px;

            margin-top: 4px;

            border: 0;
            border-radius: 999px;

            background: #b7ff3c;
            color: #101010;

            font-size: 14px;
            font-weight: 800;

            cursor: pointer;

            transition:
                transform .2s ease,
                background .2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            background: #caff73;
        }

        button:focus-visible {
            outline: 3px solid
                rgba(183,255,60,.35);

            outline-offset: 3px;
        }

        .back-site {
            display: block;

            margin-top: 24px;

            text-align: center;

            color: #777;
            font-size: 13px;

            text-decoration: none;
        }

        .back-site:hover {
            color: #fff;
        }

        @media (max-width: 480px) {

            .login-card {
                padding: 30px 22px;
            }

            h1 {
                font-size: 28px;
            }
        }

    </style>

</head>


<body>

<div class="login-card">

    <div class="admin-brand">
        <span>&lt;</span>
        SLH
        <span>/&gt;</span>
    </div>


    <h1>Admin Login</h1>

    <p class="subtitle">
        Portfolio management dashboard
    </p>


    <?php if ($error !== ''): ?>

        <div
            class="alert"
            role="alert"
            aria-live="polite"
        >
            <?= e($error) ?>
        </div>

    <?php endif; ?>


    <form
        method="POST"
        autocomplete="on"
    >

        <?= csrf_field() ?>


        <label for="username">
            Username
        </label>

        <input
            id="username"
            type="text"
            name="username"
            value="<?= e($username) ?>"
            autocomplete="username"
            maxlength="100"
            required
            autofocus
        >


        <label for="password">
            Password
        </label>

        <input
            id="password"
            type="password"
            name="password"
            autocomplete="current-password"
            maxlength="255"
            required
        >


        <button type="submit">
            Login →
        </button>

    </form>


    <a
        href="<?= e(url()) ?>"
        class="back-site"
    >
        ← Back to portfolio
    </a>

</div>

</body>

</html>