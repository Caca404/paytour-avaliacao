<?php
    require_once 'vendor/autoload.php';

    $curriculoController = new \App\Controller\CurriculoController();

    if(!empty($_POST)) var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="src/css/main.css">

        <title>Paytour Curriculos</title>
    </head>
    <body>
        <header class="my-4 text-center">
            <h1>Paytour - Envio de Currículo</h1>
        </header>
        <main class="container mb-4">
            <div class="row d-flex justify-content-center">
                <form class="col-lg-10 col-12" action="<?php $curriculoController->submitCurriculo(); ?>" 
                    onsubmit="return validateForm();">
        
                    <div class="mb-3">
                        <label for="nome">Nome *</label>
                        <input type="text" name="nome" id="nome" class="form-control" 
                            aria-describedby="invalidNome" autocomplete="off">

                        <div id="invalidNome" class="invalid-feedback">
                            Nome é obrigatório.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" 
                            aria-describedby="invalidEmail" autocomplete="off">

                        <div id="invalidEmail" class="invalid-feedback">
                            Email é obrigatório.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="telefone">Telefone *</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" 
                            placeholder="(XX) XXXX-XXXX" aria-describedby="invalidTelefone"
                            autocomplete="off">

                        <div id="invalidTelefone" class="invalid-feedback">
                            Telefone é obrigatório.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cargo">Cargo desejado *</label>
                        <textarea class="form-control" name="cargo" 
                            aria-describedby="invalidCargo" id="cargo" cols="30" 
                            rows="3"></textarea>

                        <div id="invalidCargo" class="invalid-feedback">
                            Cargo desejado é obrigatório.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="escolaridade">Escolaridade *</label>
                        <select name="escolaridade" id="escolaridade" class="form-control"
                            aria-describedby="invalidEscolaridade">

                            <option value="" selected disabled>Escolha uma escolaridade</option>
                            <option value="FI">Fundamental Incompleto</option>
                            <option value="FC">Fundamental Completo</option>
                            <option value="MI">Ensino Médio Incompleto</option>
                            <option value="MC">Ensino Médio Completo</option>
                            <option value="SI">Superior Incompleto</option>
                            <option value="SC">Superior Completo</option>
                        </select>

                        <div id="invalidEscolaridade" class="invalid-feedback">
                            Escolaridade é obrigatório.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control" name="observacoes" 
                            aria-describedby="invalidObservacoes" id="observacoes" cols="30" 
                            rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="mb-1">
                            Coloque seu currículo aqui (.pdf, .doc ou .docx - Tam. máximo: 1MB) *
                        </label>
                        <input class="form-control" type="file" name="file" id="file"
                            aria-describedby="invalidCurriculo invalidCurriculoType 
                            invalidCurriculoSize">

                        <div id="invalidCurriculo" class="invalid-feedback">
                            Curriculo é obrigatório.
                        </div>
                        <div id="invalidCurriculoType" class="invalid-feedback">
                            Formato do Curriculo não é aceito.
                        </div>
                        <div id="invalidCurriculoSize" class="invalid-feedback">
                            Tamanho do curriculo é grande demais. Máx.: 1MB.
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="date" class="mb-1">
                                Data *
                            </label>
                            <input class="form-control" type="date" name="date" id="date"
                                aria-describedby="invalidData"
                                max="<?php echo (new DateTime())->format('Y-m-d'); ?>">

                            <div id="invalidData" class="invalid-feedback">
                                Data inválida.
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="time" class="mb-1">
                                Hora *
                            </label>
                            <input class="form-control" type="time" name="time" id="time"
                                aria-describedby="invalidTime">

                            <div id="invalidTime" class="invalid-feedback">
                                Tempo inválido.
                            </div>
                        </div>

                    </div>
        
                    <button class="btn btn-purple w-100 p-2">Enviar Curriculo</button>
                </form>
            </div>
        </main>
    </body>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="vendor/igorescobar/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="src/js/main.js"></script>
</html>