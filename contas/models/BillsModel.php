<?php

require_once __DIR__ ."/../core/Model.php";

// Model para contas a pagar, concentra as funções relacionadas às contas a pagar
class BillsModel extends Model {

    // Método para criação de novas contas a pagar
    public function createBill($value, $dueDate, $companyId){
        // Preparação de uma statement para inserir uma nova conta na tabela, os espaços com "?" são onde as variáveis entrarão
        $stmt = $this->db->prepare("INSERT INTO tbl_conta_pagar (valor, data_pagar, id_empresa) VALUES (?, ?, ?)");
        // Execução da statement criada passando as variáveis na ordem certa para o comando SQL
        return $stmt->execute([$value, $dueDate, $companyId]); // Retorna um Boolean que diz se a statement teve sucesso ao ser executada ou não
    }

    // Método para pegar as contas existentes, pode receber o Id da empresa a qual a conta é destinada, um valor, um comparador...
    // que comparará as contas existentes com o valor passado e uma data, para pegarmos as contas criadas em uma data específica
    public function getBills($companyId = null, $value = null, $comparison = null, $dueDate = null) {
        // Criação da query base que será passada caso nenhum dos parâmetros forem passados, por padrão, esta query retornará todas as contas existentes
        $query = "SELECT cp.*, e.nome as empresa_nome FROM tbl_conta_pagar cp 
                  JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa WHERE 1=1";
        // Array que guardará os parâmetros à serem passados na execução da query
        $params = [];

        // As condições a seguir adicionarão filtros à busca
        if ($companyId !== null) {
            $query .= " AND cp.id_empresa = ?"; // Adiciona mais condições no WHERE
            $params[] = $companyId; // Adiciona o valor no array de parâmetros
        }
        if ($value !== null && $comparison !== null && in_array($comparison, ['>', '<', '='])) {
            $query .= " AND cp.valor $comparison ?"; // Adiciona mais condições no WHERE
            $params[] = $value;
        }
        if ($dueDate !== null) {
            $query .= " AND cp.data_pagar = ?"; // Adiciona mais condições no WHERE
            $params[] = $dueDate;
        }

        // Preparação da statement para execução da query passada
        $stmt = $this->db->prepare($query);
        $stmt->execute($params); // Adição dos parâmetros a serem passados e execução da statement
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos as linhas da execução realizada como um array associativo 
    }

    // Método que atualiza uma conta, podendo alterar o valor e a data
    public function updateBill($billId, $newValue = null, $newDate = null){
        // Nem todos os campos precisam ser alterados, então esta função personaliza a query baseado nos campos passados, se eles existirem
        $fields = [];
        $params = [];

        // Checa se existe um novo valor para o preço da conta, adicionando o parãmetro a um array e a string a ser adicionada na query em outro
        if($newValue !== null){
            $fields[] = "valor = ?";
            $params[] = $newValue;
        }

        if($newDate !== null){
            $fields[] = "data_pagar = ?";
            $params[] = $newDate;
        }

        // Checa se existem campos a serem alterados, caso não, retorna false e encerra a execução
        if(count($fields) === 0){
            return false;
        }

        $params[] = $billId; // Adiciona o ID da conta como o último parãmetro a ser passado
        $stmt = $this->db->prepare("UPDATE tbl_conta_pagar SET ". implode(", ", $fields) . " WHERE id_conta_pagar = ?"); // Junta o array de campos a serem alterados em uma única string
        return $stmt->execute($params); // Atribui os parâmetros a execução da statement
    }

    // Método que altera apenas o status da conta
    public function changeStatus($billId, $newStatus) {
        $query = "UPDATE tbl_conta_pagar SET pago = ? WHERE id_conta_pagar = ?"; // Cria uma query que terá o novo status da conta e o id da conta a ser alterado como parâmetros
        $stmt = $this->db->prepare($query); // Prepara a statement
        return $stmt->execute([$newStatus, $billId]); // Executa a statement passando os parâmetros necessários
    }

    // Método que deleta contas a pagar
    public function deleteBill($billId) {
        $query = "DELETE FROM tbl_conta_pagar WHERE id_conta_pagar = ?"; // Query para deletar uma conta a pagar baseado no ID
        $stmt = $this->db->prepare($query); // Prepara a statement
        return $stmt->execute([$billId]); // Executa a statement passando o id da conta a pagar como parãmetro
    }
}