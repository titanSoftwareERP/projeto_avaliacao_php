document.addEventListener("DOMContentLoaded", function () {
  // Aguarda o carregamento da DOM
  if (document.querySelector("#filterForm")) {
    // Atribui a função de carregar as contas a pagar à submissão do formulário #filterForm
    document
      .querySelector("#filterForm")
      .addEventListener("submit", function (event) {
        event.preventDefault(); // Impede a página de recarregar ao realizar ao carregar as contas
        fetchBills(); // Pede ao back end as contas criadas, passando os filtros desejados
      });
  }
  if (document.querySelector("#createForm")) {
    // Atribui a função de criar nova conta à submissão do formulário #createForm
    document
      .querySelector("#createForm")
      .addEventListener("submit", function (event) {
        event.preventDefault(); // Novamente, impede a página de recarregar ao fazer essa operação
        createBill(); // Envia a requisição de criação ao back end
      });
  }

  fetchBills(); // Carrega as contas a pagar ao abrir a página, deve retornar todas as contas, considerando que no carregar da DOM...
  // não houve tempo para colocar parâmetros no formulário
  fetchCompanies(); // Carrega as empresas cadastradas para serem selecionadas no Select ao abrir a página
});

// Função que faz uma requisição GET ao back end, este retorna todas as contas existentes e então o front cria uma linha na tabela...
// para cada conta existente
function fetchBills() {
  // Coleta das informações para filtrar a busca
  const companyId = document.querySelector("#filterCompanyId").value;
  const value = document.querySelector("#value").value;
  const comparison = document.querySelector("#comparison").value;
  const dueDate = document.querySelector("#dueDate").value;

  // Cria uma variável para guardar as informações de filtração na URL caso elas existam
  const params = new URLSearchParams();
  if (companyId) params.append("companyId", companyId);
  if (value) params.append("value", value);
  if (comparison) params.append("comparison", comparison);
  if (dueDate) params.append("dueDate", dueDate);

  fetch("get_bills.php?" + params) // Faz a requisição
    .then((response) => response.json()) // converte os dados obtidos de json para um array de objetos
    .then((data) => {
      const tbody = document.querySelector("#billsTable tbody"); // Pega o corpo da tabela no HTML
      tbody.innerHTML = "";

      if (data.length > 0) {
        data.forEach((bill) => {
          // Itera sobre o array de objetos montando o HTML da nova linha da tabela baseado nas informações da conta atual
          const row = document.createElement("tr"); // Cria uma nova linha de tabela
          const companyNameCell = document.createElement("td"); // Cria uma célula na tabela para guardar o nome da empresa
          companyNameCell.textContent = bill.empresa_nome; // Associa a célula ao nome
          const valueCell = document.createElement("td"); // Cria uma célula ao valor da conta
          valueCell.contentEditable = true; // Define que esta célula terá o valor editável
          valueCell.textContent = formatCurrency(bill.valor); // Associa a célula ao valor
          const dueDateCell = document.createElement("td"); // Cria uma célula para a data de pagamento da conta
          dueDateCell.contentEditable = true; // Define que esta célula será editável
          dueDateCell.textContent = bill.data_pagar; // Associa a célula à data de pagamento
          const statusCell = document.createElement("td"); // Cria uma linha para guardar o status da conta
          statusCell.textContent = bill.pago ? "Sim" : "Não"; // Associa a célula ao status da conta, se o valor for 0, então não foi paga, caso o valor seja 1, ela é considerada paga
          const currentValue = document.createElement("td"); // Cria uma célula para guardar o valor que será pago na conta, caso ela seja paga hoje
          currentValue.textContent = formatCurrency(
            calculateAmount(bill.valor, bill.data_pagar)
          ); // Associa a célula ao valor que será pago na conta caso o pagamento ocorra hoje

          const acoesCell = document.createElement("td"); // Cria uma célula para os botões de ações
          const saveButton = document.createElement("button"); // Cria um botão para salvar as alterações
          saveButton.className = "save"; // Define uma classe ao botão
          saveButton.textContent = "Salvar"; // Define a palavra que será visível ao usuário no botão de salvar
          saveButton.onclick = () => saveBill(row, bill.id_conta_pagar); // Associa o clique do botão à função de salvar as modificações da conta
          const deleteButton = document.createElement("button"); // Cria um botão para deletar a conta
          deleteButton.className = "delete"; // Associa uma classe ao botão
          deleteButton.textContent = "Excluir"; // Define a palavra que será visível ao usuário no botão de deletar
          deleteButton.onclick = () => deleteConta(bill.id_conta_pagar); // Associa o clique do botão à função de deletar conta
          const changeStatusBtn = document.createElement("button"); // Cria um botão para alterar o status da conta
          changeStatusBtn.className = "change-status"; // Associa uma classe ao botão
          changeStatusBtn.textContent = "Alterar status"; // Define o texto que será visível ao usuário no botão de alterar status
          changeStatusBtn.onclick = () =>
            changeStatus(bill.id_conta_pagar, bill.pago); // Associa o clique do botão à função de mudar status, passando o ID desta conta e o status atual

          // Insere os botões criados na célula de ações
          acoesCell.appendChild(saveButton);
          acoesCell.appendChild(deleteButton);
          acoesCell.appendChild(changeStatusBtn);

          // Insere as células na linha criada anteriormente especificamente na ordem certa
          row.appendChild(companyNameCell);
          row.appendChild(valueCell);
          row.appendChild(dueDateCell);
          row.appendChild(statusCell);
          row.appendChild(currentValue);
          row.appendChild(acoesCell);

          // Insere a linha criada no corpo da tabela
          tbody.appendChild(row);
        });
      } else {
        // Caso seja retornado um array vazio, esta mensagem é transmitida.
        const row = document.createElement("tr");
        const cell = document.createElement("td");
        cell.setAttribute("colspan", "4");
        cell.textContent = "Nenhuma conta a pagar encontrada.";
        row.appendChild(cell);
        tbody.appendChild(row);
      }
    })
    .catch((error) => console.error("Erro:", error));
}

function fetchCompanies() {
  // Busca as empresas e insere elas no select tanto de criação de conta quanto de filtração de contas
  fetch("get_companies.php")
    .then((response) => response.json())
    .then((data) => {
      const selectList = document.querySelectorAll(".companyId"); // Pega todos os Selects com a classe companyId
      data.forEach((company) => {
        selectList.forEach((select) => {
          const option = document.createElement("option");
          option.value = company.id_empresa; // O valor a ser passado quando selecionamos a empresa desejada é o ID e não o nome
          option.textContent = company.nome;
          select.appendChild(option);
        });
      });
    })
    .catch((error) => console.error("Erro:", error));
}

function createBill() {
  // Faz a requisição para o back end criar uma nova conta

  // Pega os valores no formulário
  const companyId = document.querySelector("#createCompanyId").value;
  const value = document.querySelector("#createValue").value;
  const dueDate = document.querySelector("#createDueDate").value;

  // Monta o objeto da requisição com os nomes dos campos esperados pelo back end
  const formData = {
    value: value,
    date: dueDate,
    companyId: companyId,
  };

  fetch("create_bill.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(formData), // Transforma os dados em JSON e define que eles estarão no corpo da requisição
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Conta criada com sucesso!");
        fetchBills(); // Atualiza a lista de contas a pagar
      } else {
        alert("Erro ao criar conta.");
      }
    })
    .catch((error) => console.error("Erro:", error));
}

// Pega as informações editadas da linha na tabela, junto com o id da conta e efetua a alteração
function saveBill(row, billId) {
  const cells = row.querySelectorAll("td");
  const newValue = unformatCurrency(cells[1].textContent);
  const newDueDate = cells[2].textContent;

  // Monta o objeto da requisição com os nomes dos campos esperados pelo back end
  const data = {
    billId: billId,
    newValue: newValue,
    newDate: newDueDate,
  };

  fetch("update_bill.php", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data), // Transforma as informações em JSON e coloca as mesmas no corpo da requisição
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Conta atualizada com sucesso!");
        fetchBills(); // Atualiza a lista de contas a pagar
      } else {
        alert("Erro ao atualizar conta.");
      }
    })
    .catch((error) => console.error("Erro:", error));
}

// Deleta a conta
function deleteConta(billId) {
  if (confirm("Tem certeza que deseja excluir esta conta?")) {
    fetch("delete_bill.php", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ billId: billId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Conta excluída com sucesso!");
          fetchBills(); // Atualiza a lista de contas a pagar
        } else {
          alert("Erro ao excluir conta.");
        }
      })
      .catch((error) => console.error("Erro:", error));
  }
}

// Altera o status de pagamento da conta
function changeStatus(billId, actualStatus) {
  const newStatus = actualStatus === 0 ? 1 : 0; // Utiliza o status atual como base para saber qual deve ser o novo status da conta
  fetch("change_status.php", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ billId: billId, newStatus: newStatus }), // Transforma os dados Id da conta e novo status em JSON e manda no corpo da requisição
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Conta marcada como paga com sucesso!");
        fetchBills();
      } else {
        alert("Erro ao marcar conta como paga.");
      }
    })
    .catch((error) => console.error("Erro:", error));
}

// Calcula o valor que será pago na conta caso ela seja paga no dia corrente
// Possível melhoria: Alterar o banco de dados e back end para poder comportar o campo "valor_pago" e assim definir o valor que foi pago...
// na conta, e caso exista esse campo, a conta ser definitivamente considerada como "paga" e não pode ser alterada, apenas excluída
function calculateAmount(value, payDate) {
  const today = new Date(); // Cria uma data para o dia atual
  const dueDate = new Date(payDate); // Faz uma hora no formato entendido pelo Js baseado na data da conta

  const isToday = // Define se a data de hoje é igual a data da conta
    today.getDate() === dueDate.getDate() + 1 &&
    today.getMonth() === dueDate.getMonth() &&
    today.getFullYear() === dueDate.getFullYear();

  if (today < dueDate) {
    return (value * 0.95).toFixed(2); // 5% de desconto
  } else if (isToday) {
    return value; // Sem descontos
  } else {
    return (value * 1.1).toFixed(2); // 10% a mais no valor
  }
}

function formatCurrency(value) {
  // Formata o valor da conta
  return new Intl.NumberFormat("pt-BR", {
    // Api nativa do JavaScript que permite formatar um número para um formato de moeda específico
    style: "currency",
    currency: "BRL",
  }).format(value);
}

function unformatCurrency(value) {
  // "Desformata" o valor mostrado para o mesmo poder ser passado no método de atualização de conta
  const unformatted = value.replace(/[^0-9,-]+/g, "").replace(",", "."); // Primeiro, remove qualquer caractere que não seja número, vírgulas ou hífens e então troca vírgulas por pontos
  return parseFloat(unformatted).toFixed(2); // Transforma o valor em float novamente mantendo as duas casas decimais
}
