<style>
    textarea{
        visibility: visible !important;
    }
</style>

<section>
    <h2>Pages</h2>
    <?php echo anchor('admin/page/edit','<i class="icon-plus"></i> Add a page') ;  ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Parent</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pages)):  ?>
            <?php foreach ($pages as $page):  ?>
                <tr>
                    <td><?php echo anchor('admin/page/edit/'.$page->id,$page->title)?></td>
                    <td><?php


                       if ( $page->parent_id!=0 )
                       {
                          echo anchor('admin/page/edit/'.$page->parent_id , $page-> parent_title);

                       }


                        ?></td>
                    <td><?php echo btn_edit('admin/page/edit/'.$page->id)  ?></td>
                    <td><?php echo btn_delete('admin/page/delete/'.$page->id)  ?></td>
                </tr>

            <?php  endforeach; ?>
            <?php else :?>
            <tr>
               <td colspan="3"> We could not find any users .</td>
            </tr>
            <?php endif; ?>


        </tbody>
    </table>
</section>