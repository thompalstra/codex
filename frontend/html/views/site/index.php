<?php
use codex\web\View;
use codex\widgets\Form;
?>

<h2>site/index</h2>
<section>

    <?php $form = new Form(); ?>
    <?=$form->open()?>
        <div class='col lg6'>
            <?=$form->field($user, 'username')->input([
                'type'=>'username',
                'pattern' => '.{4,10}',
                'required' => ''
            ])?>
            <?=$form->field($user, 'password')->input([
                'type'=>'password',
                'pattern' => '.{4,10}',
                'required' => ''
            ])?>
        </div>
    <?=$form->close()?>

</section>
