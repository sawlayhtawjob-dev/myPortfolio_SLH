<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM skills WHERE id = ?",
        [(int) $_GET['delete']]
    );

    redirect('admin/skills.php');
}

if (is_post()) {

    verify_csrf();

    $id = (int) post('id');

    $data = [
        trim((string) post('name')),
        trim((string) post('category')),
        trim((string) post('icon')),
        (int) post('sort_order', 0)
    ];

    if ($id > 0) {

        db_execute(
            "UPDATE skills
             SET name=?, category=?, icon=?, sort_order=?
             WHERE id=?",
            [...$data, $id]
        );

    } else {

        db_execute(
            "INSERT INTO skills
             (name, category, icon, sort_order)
             VALUES (?, ?, ?, ?)",
            $data
        );

    }

    redirect('admin/skills.php');
}

$edit = null;

if (isset($_GET['edit'])) {

    $edit = db_one(
        "SELECT * FROM skills WHERE id = ?",
        [(int) $_GET['edit']]
    );
}

$items = db_all(
    "SELECT * FROM skills ORDER BY sort_order, id"
);

$pageTitle = 'Skills';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>CONTENT</span>
            <h1>Skills</h1>
        </div>
    </div>


    <form method="POST" class="admin-form">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= e((string)($edit['id'] ?? 0)) ?>"
        >

        <div class="form-two">

            <div>
                <label>Skill</label>
                <input
                    type="text"
                    name="name"
                    required
                    value="<?= e($edit['name'] ?? '') ?>"
                >
            </div>

            <div>
                <label>Category</label>
                <input
                    type="text"
                    name="category"
                    required
                    value="<?= e($edit['category'] ?? '') ?>"
                >
            </div>

        </div>

        <div class="form-two">

            <div>
                <label>Icon</label>
                <input
                    type="text"
                    name="icon"
                    value="<?= e($edit['icon'] ?? '') ?>"
                >
            </div>

            <div>
                <label>Sort Order</label>
                <input
                    type="number"
                    name="sort_order"
                    value="<?= e((string)($edit['sort_order'] ?? 0)) ?>"
                >
            </div>

        </div>

        <button class="admin-btn">
            <?= $edit ? 'Update Skill' : 'Add Skill' ?>
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td><?= e($item['name']) ?></td>

                    <td><?= e($item['category']) ?></td>

                    <td><?= e((string)$item['sort_order']) ?></td>

                    <td class="actions">

                        <a
                            href="?edit=<?= $item['id'] ?>"
                        >
                            Edit
                        </a>

                        <a
                            href="?delete=<?= $item['id'] ?>"
                            onclick="return confirm('Delete this skill?')"
                            class="danger"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</main>
</div>

</body>
</html>