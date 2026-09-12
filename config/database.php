<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';


/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    try {

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            DB_HOST,
            DB_NAME
        );

        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_PERSISTENT         => false,
            ]
        );

        return $pdo;

    } catch (PDOException $e) {

        /*
        |--------------------------------------------------------------------------
        | Log the real database error
        |--------------------------------------------------------------------------
        |
        | Never expose database credentials, host details, SQL errors,
        | or stack traces to visitors.
        |
        */

        error_log(
            'Database connection failed: ' . $e->getMessage()
        );


        /*
        |--------------------------------------------------------------------------
        | Production Response
        |--------------------------------------------------------------------------
        */

        if (defined('IS_PRODUCTION') && IS_PRODUCTION) {

            http_response_code(503);

            exit(
                '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Service Unavailable</title>
                    <style>
                        body {
                            margin: 0;
                            min-height: 100vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-family: Arial, sans-serif;
                            background: #f7f7f7;
                            color: #222;
                        }

                        .error-box {
                            width: min(90%, 520px);
                            padding: 40px 30px;
                            background: #fff;
                            border: 1px solid #e5e5e5;
                            border-radius: 16px;
                            text-align: center;
                            box-shadow: 0 15px 40px rgba(0,0,0,.08);
                        }

                        h1 {
                            margin: 0 0 12px;
                            font-size: 28px;
                        }

                        p {
                            margin: 0;
                            color: #666;
                            line-height: 1.7;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h1>Service Temporarily Unavailable</h1>
                        <p>
                            We are currently experiencing a temporary issue.
                            Please try again later.
                        </p>
                    </div>
                </body>
                </html>'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Development Response
        |--------------------------------------------------------------------------
        */

        http_response_code(500);

        exit(
            '<div style="
                font-family:Arial,sans-serif;
                max-width:700px;
                margin:80px auto;
                padding:30px;
                border:1px solid #ddd;
                border-radius:15px;
                background:#fff;
                color:#222;
            ">
                <h2>Database Connection Error</h2>

                <p>
                    Please check
                    <strong>config/config.php</strong>.
                </p>

                <p>
                    Make sure MySQL is running and
                    <strong>database/schema.sql</strong>
                    has been imported.
                </p>
            </div>'
        );
    }
}