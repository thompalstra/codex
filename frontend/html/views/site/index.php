<?php
use codex\web\View;
use codex\widgets\Form;
?>

<h2>site/index</h2>


<section>
site/index
<?=View::renderFile('file')?>
</section>
<section>
    <?php $form = new Form(); ?>
    <?=$form->open()?>
        <?=$form->field($user, 'username')->input([
            'class' => 'input input-flat'
        ])?>
        <?=$form->field($user, 'email[]')->input()?>
    <?=$form->close()?>
</section>
