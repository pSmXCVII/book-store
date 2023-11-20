import { showDialog, setPageTitle } from "/js/functions.js";
import { addItem, getItemById, updateItem } from "/assets/api.js";
import renderToolbar from "/js/importToolbar.js"

renderToolbar();

const form = document.querySelector('form#publishers-form');
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  if (!id) {
    const response = await (await addItem(formData, 'publishers'));
    const json = (await response.json());
    if (response.ok) {
      showDialog({ title: 'Cadastrado com sucesso', message: 'Deseja permanecer com o cadastro aberto?' }, [
        { label: 'Fechar cadastro', variant: 'danger', onclick: () => location.replace('../') },
        { label: 'Permanecer', variant: 'primary', onclick: () => location.replace(`?id=${json.id}`) }
      ]);
    }
  } else {
    const response = await (await updateItem(id, formData, 'publishers'));
    if (response.ok) {
      showDialog({ title: 'Alterado com sucesso', message: 'Deseja permanecer com o cadastro aberto?' }, [
        { label: 'Fechar cadastro', variant: 'danger', onclick: () => location.replace('../') },
        { label: 'Permanecer', variant: 'primary' }
      ]);
    }
  }
});

if (id) {
  const data = await getItemById(id, 'publishers');
  if (data) {
    document.querySelector('#name').value = data?.name;
    document.querySelector('#description').value = data?.description;
    setPageTitle(`Editoras: ${data?.name}`);
  }
}