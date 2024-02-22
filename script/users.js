document.addEventListener('DOMContentLoaded', () => {
  const showFormBtn = document.getElementById('showFormBtn');
  const closeForm = document.getElementById('closeFilter');
  const actionBtns = [showFormBtn, closeForm];
  
  const filterForm = document.getElementById('filterForm');

  for (const btn of actionBtns) {
    btn.addEventListener('click', () => {
      filterForm.classList.toggle('hidden');
      closeForm.classList.toggle('hidden');
      showFormBtn.classList.toggle('hidden');
    });
  };
})