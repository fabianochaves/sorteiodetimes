<script src="js/loadModal.js"></script>

<div class="modal fade" id="ModalEditar" style="z-index: 999999999" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Edição de Menu/Módulo</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_editar" id="id_editar" />
                <br>
                <div id="dados_editar"></div>
                <center>
                    <div style="width: 85%">
                        <img id="aguarde_editar" src="<?php echo URL::getBase(); ?>assets/images/gif/loading.gif"
                            style="display:none;" />

                        <div class="alert alert-danger" role="alert" id="erro_editar" style="display:none;">
                            <center><b><span id="msg_erro"></span></b></center>
                        </div>

                        <div class="alert alert-success" role="alert" id="sucesso_editar" style="display:none;">
                            <center><b>Editado com Sucesso!</b></center>
                        </div>
                    </div>
                </center>
            </div>
            <div class="modal-footer">
                <button id="cancela_editar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i
                        class="fa fa-remove" aria-hidden="true"></i></button>
                <button type="button" id="confirma_editar" class="btn btn-success">Confirmar <i class="fa fa-check"
                        aria-hidden="true"></i></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalDesativar" style="z-index: 999999999" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Alteração de Status</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_desativar" id="id_desativar" />
                <input type="hidden" name="status_desativar" id="status_desativar" />

                Deseja alterar o status do Menu/Módulo?
                <br>
                <br>
                <div id="dados_desativar" style="text-align: justify; overflow-y: auto; max-height: 200px"></div>
                <br>
                <center><img src="assets/images/gif/aguarde.gif" style="width: 150px; height: 150px; display: none;"
                        id="aguarde_desativar" /></center>
                <div class="alert alert-danger" role="alert" id="erro_desativar" style="display:none;">
                    <center><b> Erro ao alterar status. Contate o Suporte!</b></center>
                </div>
                <div class="alert alert-success" role="alert" id="sucesso_desativar" style="display:none;">
                    <center><b> Status alterado com Sucesso!</b></center>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-remove"
                        aria-hidden="true"></i></button>
                <button type="button" id="confirma_desativar" class="btn btn-success">Confirmar <i class="fa fa-check"
                        aria-hidden="true"></i></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalAguarde" style="z-index: 9999" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Aguarde... <span id="nro_os_status"></span></h4>
            </div>
            <div class="modal-body">

                <center><img src="assets/images/gif/aguarde.gif" style="width: 150px; height: 150px;" /></center>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>