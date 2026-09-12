<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['read'])) {

    db_execute(
        "UPDATE messages SET is_read=1 WHERE id=?",
        [(int) $_GET['read']]
    );

    redirect('admin/messages.php');
}

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM messages WHERE id=?",
        [(int) $_GET['delete']]
    );

    redirect('admin/messages.php');
}

$messages = db_all(
    "SELECT *
     FROM messages
     ORDER BY created_at DESC"
);

$pageTitle = 'Messages';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>INBOX</span>
            <h1>Messages</h1>
        </div>
    </div>


    <div class="message-list">

        <?php if (!$messages): ?>

            <div class="empty-state">
                No messages yet.
            </div>

        <?php endif; ?>


        <?php foreach ($messages as $message): ?>

            <article
                class="message-card <?= !$message['is_read'] ? 'unread' : '' ?>"
            >

                <div class="message-head">

                    <div>

                        <strong>
                            <?= e($message['name']) ?>
                        </strong>

                        <a
                            href="mailto:<?= e($message['email']) ?>"
                        >
                            <?= e($message['email']) ?>
                        </a>

                    </div>

                    <small>
                        <?= e($message['created_at']) ?>
                    </small>

                </div>


                <h3>
                    <?= e($message['subject'] ?: 'No Subject') ?>
                </h3>


                <p>
                    <?= nl2br(e($message['message'])) ?>
                </p>


                <div class="message-actions">

                    <?php if (!$message['is_read']): ?>

                        <a
                            href="?read=<?= $message['id'] ?>"
                        >
                            Mark as read
                        </a>

                    <?php endif; ?>

                    <a
                        href="?delete=<?= $message['id'] ?>"
                        class="danger"
                        onclick="return confirm('Delete this message?')"
                    >
                        Delete
                    </a>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

</div>

</main>
</div>

</body>
</html>