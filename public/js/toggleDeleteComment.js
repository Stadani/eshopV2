
function toggleDeleteForm(commentId) {
    const deleteForm = document.getElementById(`deleteForm${commentId}`);
    deleteForm.style.display = deleteForm.style.display === 'none' ? 'block' : 'none';
}
