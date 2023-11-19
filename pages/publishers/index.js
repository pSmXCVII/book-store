import { getAllByEntity, getItemsByName } from "/assets/api.js";
import { generateCardsList } from "/js/functions.js";

const listContainer = document.querySelector('.items-list');

if (listContainer) generateCardsList(await getAllByEntity('publishers'), listContainer);

document.addEventListener('submit', async (event) => {
  event.preventDefault();

  const searchElement = document.querySelector("input#search");
  const response = getItemsByName(searchElement.value, 'publishers')

  const json = await response;

  if (json && listContainer) {
    generateCardsList(json, listContainer);
  }
});