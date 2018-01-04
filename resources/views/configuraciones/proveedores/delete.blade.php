<div class="modal fade" id="delete" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/proveedores/dardebaja" accept-charset="UTF-8" class="form-horizontal id">
                <div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="H4"> Dar de baja el proveedor</h4>
                </div>
                <div class="modal-body">
                    <p class="help-block">Esta seguro que desea dar de baja el proveedor ?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_proveedor" value=""></input>
                    <input type="submit" class="btn btn-success" value="Dar de baja"></input>
                </div>
            </form>
        </div>
    </div>
</div>
