<section class="content">
    <table width="100%">
        <tr>
            <td>
                {!!  str_replace(
                array('[numero]', '[data_curta]', '[data_longa]', '[autores]', '[assunto]', '[conteudo]'),
                array(
                $document->number,
                ucfirst(strftime('%d/%m/%Y', strtotime($document->date))),
                ucfirst(strftime('%d de %B de %Y', strtotime($document->date))),
                $list,
                $document->content,
                $document->content),
                $document_model->content)
                !!}
            </td>
        </tr>
    </table>
</section>