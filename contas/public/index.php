<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Contas a Pagar</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container" id="createBillContainer">
        <h1>Criar conta</h1>
        <form id="createForm">
            <label for="createCompanyId">Nome da Empresa:</label>
            <select id="createCompanyId" class="companyId" name="createCompanyId" required>
                <option value="">Selecione uma empresa</option>
            </select><br>
            <label for="createValue">Valor:</label>
            <input type="number" id="createValue" name="createValue" step="0.01" required /><br>

            <label for="createDueDate">Data de Pagamento:</label>
            <input type="date" id="createDueDate" name="createDueDate" required > </input><br>

            <input type="submit" value="Create" />
        </form>
    </div>
    <div id="searchBillContainer" class="container">
    <h1>Filtrar Contas a Pagar</h1>
    <form id="filterForm">
    <label for="filterCompanyId">Nome da Empresa:</label>
        <select id="filterCompanyId" class="companyId" name="companyId">
            <option value="">Selecione uma empresa</option>
        </select><br>
        <label for="value">Valor:</label>
        <input type="number" id="value" name="value" step="0.01"><br>

        <label for="comparison">Comparador:</label>
        <select id="comparison" name="comparison">
            <option value="">Selecione</option>
            <option value="=">Igual a</option>
            <option value=">">Maior que</option>
            <option value="<">Menor que</option>
        </select><br>

        <label for="dueDate">Data de Pagamento:</label>
        <input type="date" id="dueDate" name="dueDate"><br>

        <input type="submit" value="Filter">
    </form>
    </div>
    <h2>Contas a Pagar</h2>
    <table id="billsTable">
        <thead>
            <tr>
                <th>Nome da Empresa</th>
                <th>Valor</th>
                <th>Data de Pagamento</th>
                <th>Pago</th>
                <th>Valor a ser pago</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados das contas a pagar serão inseridos aqui pelo JS -->
        </tbody>
    </table>

    <script src="./script/script.js"></script>
</body>
</html>
