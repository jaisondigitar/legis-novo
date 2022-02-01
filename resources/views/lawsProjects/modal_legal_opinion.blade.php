<div
    class="modal fade"
    id="modalressources"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    onclick="() => $isShowModal = false"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">RECURSOS</h4>
            </div>
            <div class="modal-body">

                <label>
                    texto:
                    <textarea
                        name="testetxt"
                        class="form-control descricao ckeditor"
                    ></textarea>
                </label>
                <label class="control-label">Selecione o arquivo:</label>
                    <input multiple="" class="file" name="file[]" type="file">
            </div>
            <div class="modal-footer">
                <button type="submit" style="border-radius: 5px" class="btn btn-success pull-right">Incluir</button>
                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                    style="border-radius: 5px; margin-right: 10px"
                >
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
