<?php
function publish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}
function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata,$primary,$xcrud){
    $xcrud->set_exception('ban_reason','Lol!','error');
    $postdata->set('ban_reason','lalala');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud){
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud){
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if($ext != 'pdf' && $field == 'uploads.simple_upload'){
        unlink($file_path);
        $xcrud->set_exception('simple_upload','This is not PDF','error');
    }
}

function date_example($postdata,$primary,$xcrud){
    $created = $postdata->get('datetime')->as_datetime();
    $postdata->set('datetime',$created);
}