<style>
    textarea{
        visibility: visible !important;
    }
</style>

    <h3>
        <?= empty($article->id)?'Add a new page' : 'Edit user '.$article->title ?>
    </h3>


    <?=validation_errors()?>

    <?=form_open() ?>

    <table class="table">

        <tr>
            <td>publication date</td>
            <td><?=form_input('pubdate',set_value('pubdate',$article->pubdate),'class="date_picker"'); ?></td>
        </tr>
        <tr>
            <td>Title</td>
            <td><?=form_input('title',set_value('title',$article->title)); ?></td>
        </tr>
        <tr>
            <td>Slug</td>
            <td><?=form_input('slug',set_value('slug',$article->slug)); ?></td>
        </tr>
        <tr>
            <td>Body</td>
            <td><?=form_textarea('body',set_value('body',$article->body,false),'class="tinymce"'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?=form_submit('submit','save','class="btn btn-primary"'); ?></td>
        </tr>
    </table>

    <?=form_close() ?>

    <script>

        $(function () {
            $('.date_picker').datepicker({ format:'yyyy-mm-dd' });
        })

    </script>