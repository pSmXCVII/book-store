<?php

class PublishersController
{
    public function index($mysqli)
    {
        $result = $mysqli->query("SELECT * FROM publishers");
        $publishers = [];

        while ($row = $result->fetch_assoc()) {
            $publishers[] = $row;
        }

        echo json_encode($publishers);
    }

    public function listOneById($mysqli, $id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM publishers WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();

        $publisher = $stmt->get_result()->fetch_assoc();

        if (!$publisher) {
            http_response_code(404);
            echo json_encode(['message' => 'Não foi encontrado nenhum item com esse ID']);
            return;
        }
        echo json_encode($publisher);

        $stmt->close();
    }

    public function listByName($mysqli, $name)
    {
        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM publishers WHERE name LIKE ?");
        $paramName = "%" . $name . "%";
        $stmt->bind_param('s', $paramName);

        $result = $stmt->execute();
        $publishers = [];

        if (!$result) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro interno ao buscar editoras pelo nome.']);
            return;
        }

        $queryResult = $stmt->get_result();

        while ($row = $queryResult->fetch_assoc()) {
            $publishers[] = $row;
        }

        echo json_encode($publishers);

        $stmt->close();
    }

    public function store($mysqli)
    {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $stmt = $mysqli->prepare("INSERT INTO publishers (name, description) VALUES (?, ?)");
            $stmt->bind_param('ss', $name, $description);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Editora inserida com sucesso.', 'ok' => true]);
            } else {
                echo json_encode(['message' => 'Falha ao inserir a editora.', 'ok' => false]);
            }

            $stmt->close();
        } else {
            echo json_encode(['message' => 'Algum problema ocorreu. Verifique sua conexão e tente novamente']);
        }
    }
    public function delete($mysqli, $id)
    {
        $stmt = $mysqli->prepare("DELETE FROM publishers WHERE id = ?");
        $stmt->bind_param('i', $id);

        try {
            $stmt->execute();
            http_response_code(204);
        } catch (Exception $e) {
            if ($stmt->errno === 1451) {
                http_response_code(409);
                echo json_encode(['message' => 'Ocorreu um conflito ao excluir o item', 'ok' => false]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Algum erro não esperado ocorreu. Aguarde alguns instantes e tente novamente', 'ok' => false]);
            }
        }

        $stmt->close();
    }
}
