<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
        <div class="col=md-10 col-md-offset-1">
            <ul>
            <?php foreach ($authors as $author): ?>
                <li>
                    <strong><?= $author->name ?></strong>
                    <ul>
                        <?php foreach ($author->authorBooks as $authorBook): ?>
                            <li><?= $authorBook->book->name ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
