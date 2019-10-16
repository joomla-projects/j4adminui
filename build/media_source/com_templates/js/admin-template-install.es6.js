document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('ModalInstallTemplate');
  modal.addEventListener('joomla.modal.show', () => {
    const fileInput = document.querySelector('#install_package');
    const button = document.querySelector('#select-file-button');
    button.addEventListener('click', () => {
      fileInput.click();
    });
    fileInput.addEventListener('change', () => {
      const form = document.getElementById('templateForm');

      // do field validation
      if (form.install_package.value === '') {
        alert(Joomla.JText._('PLG_INSTALLER_PACKAGEINSTALLER_NO_PACKAGE'), true);
      } else {
        const loading = document.getElementById('loading');
        if (loading) {
          loading.style.display = 'block';
        }
        form.installtype.value = 'upload';
        form.submit();
      }
    });
  });
});
