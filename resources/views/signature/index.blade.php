<style>
    .input-file {
        margin: 0;
        padding: 0;
        border: none;
        border-radius: 0;
    }
    .log {
        display: block;
        margin-top: 10px;
    }

    .display-document {
        display: grid;
        grid-template-columns: 4fr 1fr;
        grid-gap: 10px;
        height: 90%;
    }

    .embed-pdf {
        width: 100%;
        height: 100%;
    }
</style>

@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('signature.list') !!}
@endsection
@section('content')
    <main class="display-document">
        <section>
            <embed
                src="/dummy-pdf.pdf"
                class="embed-pdf"
            >
        </section>

        <section>
            <select id="certificateSelect"></select><br><br>
            <div>
                <button id="signDataButton" type="button">Assinar</button>
            </div>
        </section>
    </main>

    <script
        type="text/javascript"
        src="https://cdn.lacunasoftware.com/libs/web-pki/lacuna-web-pki-2.14.8.min.js"
        integrity="sha256-Q1U+M9pC+SnXcpLrKZj9tKXp8UG6dD7qrNsBgaXK9ZA="
        crossorigin="anonymous">
    </script>
    <script>
        const pki = new LacunaWebPKI()

        document.addEventListener('DOMContentLoaded', () => {
            pki.init(() => {
                pki.listCertificates().success(certs => {
                    const select = document.querySelector('#certificateSelect')

                    for (let cert of certs) {
                        const option = document.createElement('option')

                        option.value = cert.thumbprint
                        option.text = `${cert.subjectName} issued by ${cert.issuerName}`

                        select.append(option)
                    }
                });
            })

            document.querySelector('#signDataButton').addEventListener('click', () => {
                signFile()
            })
        })

        const signFile = () => {
            readCert()
        }

        const readCert = () => {
            const selectedCertThumb = document.querySelector('#certificateSelect').value;

            onReadCertificateCompleted(selectedCertThumb)
        }

        const onReadCertificateCompleted = async certEncoding => {
            toBase64(document.querySelector('#fileToSign').files[0], certEncoding)
        }

        const signData = async (base64File, certEncoding) => {
            const base64Doc = document.querySelector('#base64Doc')

            const base64OriginFile = new FormData

            base64OriginFile.append('document_base_64', base64File)

            const docData = await fetch('http://localhost:8088/signature/token-icp', {
                headers: { 'X-Authorization': 'legis|4d325ccf-e7b9-46e5-a715-9719a8faf36a' },
                method: 'POST',
                body: base64OriginFile
            })

            const data = await docData.json()

            const token = await signWithRestPki(data.token, certEncoding)

            const dataToSign = new FormData

            dataToSign.append('document_base_64', data.document)
            dataToSign.append('token', token)

            const resp = await fetch('http://localhost:8088/signature/sign-icp', {
                headers: { 'X-Authorization': 'legis|4d325ccf-e7b9-46e5-a715-9719a8faf36a' },
                method: 'POST',
                body: dataToSign
            })

            console.log(await resp.json())
        }

        const signWithRestPki = (token, thumbprint) => {
            return new Promise((resolve, reject) => {
                pki.signWithRestPki({ thumbprint, token })
                    .success(resolve)
                    .fail(reject)
            })
        }

        const toBase64 = (file, certEncoding) => {
            const reader = new FileReader()

            reader.onloadend = () => {
                signData(
                    reader.result
                        .replace("data:", "")
                        .replace(/^.+,/, ""),
                    certEncoding
                )
            }

            reader.readAsDataURL(file)
        }
    </script>
@endsection