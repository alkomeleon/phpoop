window.onload = function () {
  document.querySelectorAll('.remove_one_btn').forEach((item) => {
    item.addEventListener('click', async (event) => {
      let request = await fetch('/?c=cart&a=removeOne&id=' + item.dataset.id)
      let response = await request.json()
      console.log(response)
      if (response.result == 'ok') {
        document.getElementById('cart_count').innerText = response.cart_count
        if (response.item_count > 0) {
          item.parentElement.querySelectorAll('.count')[0].innerText =
            response.item_count
        } else {
          item.parentElement.remove()
        }
      }
    })
  })

  document.querySelectorAll('.remove_all_btn').forEach((item) => {
    item.addEventListener('click', async (event) => {
      let request = await fetch('/?c=cart&a=removeAll&id=' + item.dataset.id)
      let response = await request.json()
      console.log(response)
      if (response.result == 'ok') {
        document.getElementById('cart_count').innerText = response.cart_count
        item.parentElement.remove()
      }
    })
  })

  document.querySelectorAll('.clear_cart_btn').forEach((item) => {
    item.addEventListener('click', async (event) => {
      let request = await fetch('/?c=cart&a=clear')
      let response = await request.json()
      console.log(response)
      if (response.result == 'ok') {
        document.getElementById('cart_count').innerText = response.cart_count
        document.querySelectorAll('.cart_item').forEach((item) => item.remove())
      }
    })
  })
}
