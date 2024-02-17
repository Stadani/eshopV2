
function toggleDeletePostForm(postId) {
    const deleteForm = document.getElementById(`deletePostForm${postId}`);
    deleteForm.style.display = deleteForm.style.display === 'none' ? 'block' : 'none';
}
