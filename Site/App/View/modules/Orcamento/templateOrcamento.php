<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orçamento - Jahuepi</title>
  <style>
    @media print {
      body {
        width: 21cm;
        height: 29.7cm;

        /* change the margins as you want them to be. */
      }
    }

    body {
      width: 21cm;
      font-family: "Calibri", sans-serif;
    }

    .head-container {
      width: 699px;
      display: flex;
      justify-content: space-around;
    }

    .logo-container {
      display: flex;
      justify-content: end;
    }

    .total-container {
      font-size: 20px;
      margin-right: 100px;
    }

    .title {
      font-size: 28px;
      font-weight: bold;
    }

    .text-cliente {
      font-size: 23px;
      margin-left: 100px;
    }

    .text-date {
      font-size: 18px;
      font-weight: normal;
      margin-left: 100px;
    }

    .pagamento-container {
      margin-left: 100px;
    }

    .info-container {
      margin-top: 70px;
      color: rgb(143, 141, 141);
      font-size: 14px;
      line-height: 4.5px;
      margin-bottom: 50px;
    }
  </style>
</head>

<body>
  <div class="logo-container">
    <img src="View/assets/logo_orcamento.png" alt="logo_orcamento" />
  </div>

  <div class="head-container">
    <p class="title">ORÇAMENTO</p>
    <p class="budget-number title">N: <span id="num_orcamento"><?= $dados->numero ?></span></p>
  </div>

  <p>
    <strong><u><span class="text-cliente" id="nome_cliente"><?= $dados->nome_cliente ?></span>
      </u></strong>
  </p>
  <div class="text-date">
    <p>
      Jaú, <span id="dataDia"><?= $dados->data_dia ?></span>
    </p>
  </div>

  <table border="1" cellspacing="0" cellpadding="0" width="793">
    <thead>
      <tr>
        <td width="76" valign="top">
          <p align="center">
            <strong>QTD</strong>
          </p>
        </td>
        <td width="387" valign="top">
          <p align="center">
            <strong>PRODUTO</strong>
          </p>
        </td>
        <td width="104" valign="top">
          <p align="center">
            <strong>R$ VALOR</strong>
          </p>
        </td>
        <td width="132" valign="top">
          <p align="center">
            <strong>R$ TOTAL</strong>
          </p>
        </td>
      </tr>
    </thead>
    <tbody id="tableOrcamento">
      <?php foreach ($dados->arr_produtos as $produto) : ?>
        <tr>
          <td width="76" valign="top">
            <p align="center"><?= $produto->quantidade ?></p>
          </td>
          <td width="387" valign="top">
            <p align="center">
              <?= $produto->descricao ?>
            </p>
          </td>
          <td width="104" valign="top">
            <p align="center">
              <?= $produto->valor_unit ?>
            </p>
          </td>
          <td width="132" valign="top">
            <p align="center">
              <?= $produto->valor_unit * $produto->quantidade ?>
            </p>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p align="center">
    <strong></strong>
  </p>
  <div class="total-container">
    <p align="right">
      <strong>TOTAL: <span id="valor_total"><?= $dados->valor_total_formatado ?></span></strong>
    </p>
  </div>

  <p align="center">
    <strong></strong>
  </p>

  <p>
    <strong></strong>
  </p>
  <div class="info-container" align="center">
    <p>RUA: RANGEL PESTANA, 1080</p>
    <p>VILA NOVA, JAÚ-SP</p>
    <p>CEP: 17.205-030</p>
    <p>CNPJ: 35.271.120/0001-08</p>
    <p>E-mail: jahuepis@gmail.com</p>
    <p>(14) 3416-7046 - (14) 9.8179-8009</p>
  </div>
</body>

</html>