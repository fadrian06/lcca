<?php $id = uniqid() ?>

<div class="dropdown">
  <button
    class="btn btn-outline-primary dropdown-toggle"
    data-bs-toggle="dropdown"
    data-bs-auto-close="outside">
    Buscar estudiante
  </button>
  <form id="<?= $id ?>" class="dropdown-menu p-4">
    <div class="mb-3">
      <label class="mb-3">
        <span class="form-label">Por cédula</span>
        <input type="number" name="idCardSearched" class="form-control" />
      </label>
      <label class="mb-3">
        <span class="form-label" style="white-space: nowrap">
          Por nombre o apellido
        </span>
        <input name="namesSearched" class="form-control" />
      </label>
    </div>
    <dl></dl>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const $form = document.getElementById('<?= $id ?>')
    const $studentIdCard = $form.idCardSearched
    const $studentNames = $form.namesSearched
    const $list = $form.querySelector('dl')

    let timeout

    $studentIdCard.addEventListener('change', handleStudentQuery)
    $studentIdCard.addEventListener('keydown', handleStudentQuery)
    $studentNames.addEventListener('change', handleStudentQuery)
    $studentNames.addEventListener('keydown', handleStudentQuery)

    $form.addEventListener('submit', event => {
      event.preventDefault()
    })

    /** @this HTMLInputElement */
    function handleStudentQuery() {
      clearTimeout(timeout)

      timeout = setTimeout(async () => {
        $list.innerHTML = '<div class="spinner-grow mx-auto"></div>'
        const students = await search(this.value)
        let $fragment = document.createDocumentFragment()
        $fragment.innerHTML = ''

        students.forEach(student => {
          $fragment.innerHTML += `
            <a href="./estudiantes/${student.id}" class="btn btn-dark">
              <dt>${student.nationality}${student.idCard}</dt>
              <dd>${student.names} ${student.lastNames}</dd>
            </a>
          `
        })

        $list.innerHTML = $fragment.innerHTML
      }, 1000)
    }

    async function search(student = '') {
      if (!student) {
        return []
      }

      const response = await fetch(`./api/estudiantes/${student}`)
      const students = await response.json()

      return students
    }
  })
</script>
