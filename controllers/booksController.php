<?php

class BooksController
{
    public function index($mysqli)
    {
        $result = $mysqli->query("SELECT * FROM books");
        $books = [];

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        echo json_encode($books);
    }

    public function listOneById($mysqli, $id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();

        $book  = $stmt->get_result()->fetch_assoc();

        if (!$book) {
            http_response_code(404);
            echo json_encode(['message' => 'Não foi encontrado nenhum item com esse ID']);
            return;
        }
        echo json_encode($book);

        $stmt->close();
    }

    public function listByName($mysqli, $name)
    {
        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM books WHERE name LIKE ?");
        $paramName = "%" . $name . "%";
        $stmt->bind_param('s', $paramName);

        $result = $stmt->execute();

        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno ao buscar livros pelo nome.', 'ok' => false]);
            return;
        }

        $queryResult = $stmt->get_result();
        $books = [];

        while ($row = $queryResult->fetch_assoc()) {
            $books[] = $row;
        }

        echo json_encode($books);

        $stmt->close();
    }

    public function store($mysqli)
    {
        if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['publisherId'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $publisherId = $_POST['publisherId'];

            $stmt = $mysqli->prepare("INSERT INTO books (name, description, publisherId) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $description, $publisherId);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Livro inserido com sucesso.', 'ok' => true]);
            } else {
                echo json_encode(['message' => 'Falha ao inserir o livro.', 'ok' => false]);
            }

            $stmt->close();
        } else {
            echo json_encode(['message' => 'Algum problema ocorreu. Verifique sua conexão e tente novamente']);
        }
    }

    public function update($mysqli, $id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("UPDATE TABLE books SET ?=i WHERE id = ?");
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

    public function delete($mysqli, $id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['message' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("DELETE FROM books WHERE id = ?");
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
