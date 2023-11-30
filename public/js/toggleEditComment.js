
    function toggleEditForm(commentId) {
    const editForm = document.getElementById(`editForm${commentId}`);
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
}
