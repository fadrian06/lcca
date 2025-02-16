<style>
  h2 {
    animation: fadeIn;
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

<div class="container min-vh-100 d-grid justify-content-center align-content-center text-white gap-5">
  <div class="spinner-grow m-auto"></div>
  <div id="status"></div>
</div>

<script>
  const source = new EventSource('./db/install.php')
  const $status = document.querySelector('#status')

  source.addEventListener('message', event => {
    $status.innerHTML = `<h2>${event.data}</h2>`
  })
</script>
