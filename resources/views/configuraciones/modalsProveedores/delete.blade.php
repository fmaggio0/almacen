<div class="modal fade" id="delete" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            {!!Form::open(['route' => 'dardebajaproveedor', 'method'=>'post', 'class' => 'form-horizontal id'])!!}

            <div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H4"> Dar de baja el proveedor</h4>
            </div>

            <div class="modal-body">
                <p class="help-block">Esta seguro que desea dar de baja el proveedor ?</p>
            </div>

            <div class="modal-footer">
                {!! Form::hidden('id_proveedor', '') !!}
                {!! Form::submit('Dar de baja', array('class'=>'btn btn-danger')) !!}
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
