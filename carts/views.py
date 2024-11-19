from django.shortcuts import get_object_or_404
from django.http import JsonResponse
from django.views.decorators.csrf import csrf_exempt
from .models import Product, Cart, CartItem
from django.contrib.auth.decorators import login_required

@csrf_exempt
@login_required
def add_to_cart(request):
    if request.method == 'POST':
        product_id = request.POST.get('product_id')
        quantity = int(request.POST.get('quantity', 1))

        product = get_object_or_404(Product, id=product_id)
        cart, created = Cart.objects.get_or_create(user=request.user)
        cart_item, created = CartItem.objects.get_or_create(cart=cart, product=product)

        if not created:
            cart_item.quantity += quantity
        cart_item.save()

        return JsonResponse({'message': 'Товар добавлен в корзину!', 'quantity': cart_item.quantity}, status=200)
    return JsonResponse({'error': 'Неверный запрос'}, status=400)

@csrf_exempt
@login_required
def update_cart_item(request):
    if request.method == 'POST':
        cart_item_id = request.POST.get('cart_item_id')
        quantity = int(request.POST.get('quantity'))

        cart_item = get_object_or_404(CartItem, id=cart_item_id, cart__user=request.user)
        cart_item.quantity = quantity
        cart_item.save()

        return JsonResponse({'message': 'Количество обновлено', 'total_price': cart_item.total_price()}, status=200)
    return JsonResponse({'error': 'Неверный запрос'}, status=400)

@csrf_exempt
@login_required
def remove_from_cart(request):
    if request.method == 'POST':
        cart_item_id = request.POST.get('cart_item_id')

        cart_item = get_object_or_404(CartItem, id=cart_item_id, cart__user=request.user)
        cart_item.delete()

        return JsonResponse({'message': 'Товар удалён из корзины'}, status=200)
    return JsonResponse({'error': 'Неверный запрос'}, status=400)
