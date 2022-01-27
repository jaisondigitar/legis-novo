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

                {{--<form action="/action_page.php">
                    <input type="file" name="input" value="procurar">
                </form>--}}

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
<script>
    document.querySelector('#date_end').value = someDateFiveForm

        const newAdvice = (project_id) => {
        const url = "/advice/create";
        const laws_projects_id = project_id;
        const to_id = [];
        const type = [];
        const label = [];

        $('#comissao :selected').each((i, sel) =>{
            to_id[i] = $(sel).val().substr(1);
            type[i] = $(sel).val().substr(0,1);
            label[i] = $(sel).text();
        });

        const data = {
            laws_projects_id: laws_projects_id,
            document_id: 0,
            to_id: to_id,
            type: type,
            description: CKEDITOR.instances['testetxt'].getData(),
            legal_option: CKEDITOR.instances['text_test'].getData(),
            date_end: $('#date_end').val(),
        };

        console.log(data);

        if(to_id.length > 0) {
            $.ajax({
                url: url,
                data: data,
                method: 'POST'
            }).success((data) => {
                console.log(data);
                if (data) {
                    toastr.success("teste!!");
                    window.location.reload()
                } else {
                    toastr.error("Erro test!!");
                }
            })
        } else {
            toastr.error('errorrrrrr!');
        }
    }
</script>

