import { getAllByEntity, getItemsByName } from "/assets/api.js";
import { generateCardsList } from "/js/functions.js";

const listContainer = document.querySelector('.items-list');

if (listContainer) generateCardsList(await getAllByEntity('books'), listContainer);

document.addEventListener('submit', async (event) => {
  event.preventDefault();

  const searchElement = document.querySelector("input#search");
  const response = getItemsByName(searchElement.value, 'books')

  const json = await response;

  if (json && listContainer) {
    generateCardsList(json, listContainer);
  }
});