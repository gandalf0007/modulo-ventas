

<div class="bootbox modal fade bootbox-confirm in" id="descuento" tabindex="-1" role="dialog" aria-labelledby="confirmDelete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true" style="margin-top: -10px;">×</button><div class="bootbox-body">
            <div id="discount-box-wrapper">
              <h4 class="text-center">Aplicar descuento<span class="descuento_tipo"></span></h4><br>
              <div class="input-group input-group-lg">

                <span class="input-group-btn"><button class="btn btn-default porcentage_descuento " type="button">Porcentaje</button>
                </span>

                <input name="descuento_value" class="form-control" placeholder="Defina la cantidad o el porcentaje aquí ..." type="number" id="descuento_valor">

                <span class="input-group-btn"><button class="btn btn-default efectivo_descuento" type="button">Efectivo</button></span>

            </div>

            <br>

            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-2 col-md-2 col-xs-2">
                    <input class="btn btn-default btn-block btn-lg numpad7" value="7" type="button">
                  </div>

                  <div class="col-lg-2 col-md-2 col-xs-2">
                    <input class="btn btn-default btn-block btn-lg numpad8" value="8" type="button">
                  </div>

                  <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad9" value="9" type="button">
                    </div>

                    <div class="col-lg-6 col-md-6 col-xs-6"><input class="btn btn-warning btn-block btn-lg numpaddel" value="Volver" type="button">
                    </div>

                  </div><br>

                  <div class="row">

                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad4" value="4" type="button">
                    </div>

                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad5" value="5" type="button">
                    </div>

                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad6" value="6" type="button">
                    </div>

                    <div class="col-lg-6 col-md-6 col-xs-6">
                      <input class="btn btn-danger btn-block btn-lg numpadclear" value="Vaciar" type="button">
                    </div>
                  </div><br>

                  <div class="row">
                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad1" value="1" type="button">
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad2" value="2" type="button">
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad3" value="3" type="button">
                    </div>
                  </div><br>

                  <div class="row">
                    <div class="col-lg-2 col-md-2 col-xs-2">
                      <input class="btn btn-default btn-block btn-lg numpad00" value="00" type="button">
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-6"><input class="btn btn-default btn-block btn-lg numpad0" value="0" type="button">
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button data-bb-handler="confirm" type="button" class="btn btn-primary" id="confirmar_porcentage" data-dismiss="modal">Confirmar</button>

        </div>
      </div>
    </div>
  </div>