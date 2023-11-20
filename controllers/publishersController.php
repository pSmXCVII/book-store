<?php

class PublishersController
{
    public function index($mysqli)
    {
        $result = $mysqli->query("SELECT * FROM publishers ORDER BY name");
        $publishers = [];

        while ($row = $result->fetch_assoc()) {
            $publishers[] = $row;
        }

        echo json_encode($publishers);
    }

    public function listOneById($mysqli, $id)
    {
        header('Content-Type: application/json');
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
        header('Content-Type: application/json');
        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM publishers WHERE name LIKE ? ORDER BY name");
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
        header('Content-Type: application/json');
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $stmt = $mysqli->prepare("INSERT INTO publishers (name, description) VALUES (?, ?)");
            $stmt->bind_param('ss', $name, $description);

            try {
                $stmt->execute();
                $itemid = $stmt->insert_id;
                http_response_code(201);
                echo json_encode(['id' => $stmt->insert_id]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(['message' => 'Algum erro não esperado ocorreu. Aguarde alguns instantes e tente novamente', 'ok' => false, 'trace' => $th]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Algum problema ocorreu. Verifique sua conexão e tente novamente']);
        }
    }

    public function update($mysqli, $id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmtCheck = $mysqli->prepare("SELECT * FROM publishers WHERE id = ?");
        $stmtCheck->bind_param('i', $id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['erro' => 'Editora não encontrada.']);
            return;
        }

        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $stmt = $mysqli->prepare("UPDATE publishers SET name = ?, description = ? WHERE id = ?");
            $stmt->bind_param('ssi', $name, $description, $id);

            try {
                $stmt->execute();
                http_response_code(201);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(['message' => 'Algum erro não esperado ocorreu. Aguarde alguns instantes e tente novamente', 'ok' => false, 'trace' => $th]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Algum problema ocorreu. Verifique sua conexão e tente novamente']);
        }
    }

    public function delete($mysqli, $id)
    {
        header('Content-Type: application/json');
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['message' => 'ID inválido.']);
            return;
        }

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
