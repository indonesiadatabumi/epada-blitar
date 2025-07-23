<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-body">
            <button
                onclick="load_form_user_content()"
                class='btn btn-success' 
                type='button' 
                id='btn-create-user' 
                data-toggle='modal' 
                data-target='#formModal'>
                    <i class='fa fa-create'></i> 
                    CREATE USER
            </button>
            <table class='table table-bordered table-hover'>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Type</th>
                    </tr>									
                </thead>
                <tbody>
                    <?php foreach ($user_data->result() as $row){ ?>
                        <tr>
                            <td><?=$row->username?></td>
                            <td><?=$row->fullname?></td>
                            <td><?=$row->phone?></td>
                            <td><?=$row->email?></td>
                            <td><?=$row->nip?></td>
                            <td><?=$row->created_by?></td>
                            <td><?=$row->created_time?></td>
                            <td>
                                <select class="form-select" name="type" id="type" onchange="change_type_id(this, <?=$row->user_id?>)">
                                    <?php foreach($user_type_data->result() as $rowType) { ?>
                                        <option value="<?=$rowType->user_type_id?>" <?=$row->user_type_id==$rowType->user_type_id?"selected":""?>><?=$rowType->name?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>