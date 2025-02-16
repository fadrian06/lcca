<style>
  h2 {
    animation: fadeIn 500ms;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }
</style>

<div class="container min-vh-100 d-grid justify-content-center align-content-center text-white gap-5 text-center">
  <div class="spinner-grow m-auto"></div>
  <div id="status"></div>
</div>

<script>
  const source = new EventSource('./db/install.php')
  const $status = document.querySelector('#status')

  function updateStatus({
    data
  }) {
    if (data === 'end') {
      source.close()
      source.removeEventListener('message', updateStatus)
      location.reload()

      return
    }

    $status.innerHTML += `<h2>${data}</h2>`
  }

  source.addEventListener('message', updateStatus)
</script>
