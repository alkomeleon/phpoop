window.onload = function () {
  document.querySelectorAll('.add_to_cart').forEach((item) => {
    item.addEventListener('click', async (event) => {
      let request = await fetch('/?c=cart&a=add&id=' + item.dataset.id)
      let response = await request.json()
      if (response.result == 'ok') {
        document.getElementById('cart_count').innerText = response.cart_count
      }
    })
  })
}
