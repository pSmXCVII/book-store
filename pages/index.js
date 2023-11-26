import { generateCardsList } from "/js/functions.js";
import { getByQuery } from "/assets/api.js";

function renderMainSections() {
  const lastBooksQuery = `
    SELECT
      b.id, b.name, b.description, p.id as 'publisherId', p.name as 'publisherName'
    FROM books b
    JOIN publishers p
      ON b.publisherId = p.id
    ORDER BY b.createdAt
    LIMIT 6
  `;

  const topPublishersQuery = `
    SELECT
      p.id,
      p.name,
      COUNT(b.id) AS booksCount
    FROM publishers p
    LEFT JOIN books b
      ON p.id = b.publisherId
    GROUP BY
      p.id, p.name
    ORDER BY
      booksCount DESC
    LIMIT 6
  `;

  getByQuery(lastBooksQuery).then(books => {
    const booksObj = books?.map(book => ({
      id: book.id,
      name: book.name,
      description: book.description,
      publisher: {
        id: book.publisherId,
        name: book.publisherName,
      }
    }));
    const booksSection = document.querySelector('#books-list');

    generateCardsList(booksObj, booksSection, false);
  });
  getByQuery(topPublishersQuery).then(publisher => {
    const publishersSection = document.querySelector('#publishers-list')
    generateCardsList(publisher, publishersSection, false);
  })
}

renderMainSections();