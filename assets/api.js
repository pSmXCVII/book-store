const API_HOST = 'http://localhost/api';

export async function getAllByEntity(entity) {
  return fetch(`${API_HOST}/${entity}`)
    .then(response => response.json())
    .catch(error => {
      console.error('Ocorreu um erro na requisição: ' + error);
    }
    );
};

export async function getItemsByName(searchKey, entity) {
  if (searchKey) {
    return fetch(`${API_HOST}/${entity}/byname?name=${searchKey}`)
      .then(response => response.json())
      .catch(error => {
        console.error('Ocorreu um erro na requisição: ' + error);
      });
  } else {
    return await getAllByEntity(entity);
  }
};

export async function getItemById(itemId, entity) {
  if (itemId) {
    return fetch(`${API_HOST}/${entity}/byid?id=${itemId}`)
      .then(response => response.json())
      .catch(error => {
        console.error('Ocorreu um erro na requisição: ' + error);
      });
  }
};

export async function getByQuery(query) {
  if (query) {
    return fetch(`${API_HOST}/query?query=${query}`)
      .then(response => response.json())
      .catch(error => {
        console.error('Ocorreu um erro na requisição: ' + error);
      });
  }
};

export function addItem(formData, entity) {
  try {
    return fetch(`${API_HOST}/${entity}`, {
      method: 'POST',
      body: formData,
    });
  } catch (error) {
    console.error(error);
  }
};

export function updateItem(itemId, formData, entity) {
  try {
    return fetch(`${API_HOST}/${entity}/update?id=${itemId}`, {
      method: 'POST',
      body: formData,
    })
  } catch (error) {
    console.error(error);
  }
}

export async function deleteItem(itemId, entity) {
  const books = fetch(`${API_HOST}/${entity}?id=${itemId}`, {
    method: 'DELETE'
  })
    .then(response => response)
    .catch(error => {
      console.error('Ocorreu um erro na requisição: ' + error);
    });
  return books;
}