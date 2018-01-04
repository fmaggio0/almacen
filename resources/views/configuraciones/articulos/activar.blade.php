<div class="modal fade" id="activar" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="/articulos/activar" accept-charset="UTF-8" class="form-horizontal id">

                <div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="H4"> Activar articulo</h4>
                </div>

                <div class="modal-body">
                    <p class="help-block">Esta seguro que desea activar el articulo ?</p>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="id_articulo" value=""></input>
                    <input type="submit" class="btn btn-success" value="Activar"></input>
                </div>

            </form>

        </div>
    </div>
</div>
