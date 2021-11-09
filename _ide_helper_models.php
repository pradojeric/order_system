<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Cancel
 *
 * @property int $id
 * @property int $waiter_id
 * @property string $cancellable_type
 * @property int $cancellable_id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $cancellable
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCancellableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCancellableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereWaiterId($value)
 */
	class Cancel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dish[] $dishes
 * @property-read int|null $dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property int|null $order_no
 * @property int|null $receipt_no
 * @property string|null $tin_no
 * @property float|null $discount
 * @property float|null $tip
 * @property int $take_out_charge
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTakeOutCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTinNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 */
	class Configuration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomDish
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property string $description
 * @property int $printed
 * @property string $type
 * @property int $pcs
 * @property float $price_per_piece
 * @property float $price
 * @property float|null $discount
 * @property string|null $discount_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cancel[] $cancel
 * @property-read int|null $cancel_count
 * @property-read \App\Models\DiscountedItem|null $discountItem
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereDiscountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePricePerPiece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePrinted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereUpdatedAt($value)
 */
	class CustomDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $type
 * @property float|null $value
 * @property string|null $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereValue($value)
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiscountedItem
 *
 * @property int $id
 * @property string $discountable_type
 * @property int $discountable_id
 * @property int $discount_type
 * @property int $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Discount $discountType
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $discountable
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereDiscountableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereDiscountableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem whereUpdatedAt($value)
 */
	class DiscountedItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dish
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $add_on
 * @property int $sides
 * @property float $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $price_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|Dish active()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish sideDish()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereAddOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereSides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereUpdatedAt($value)
 */
	class Dish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $waiter_id
 * @property string $order_number
 * @property int $pax
 * @property string $action
 * @property string $billing_type
 * @property string|null $address
 * @property string|null $contact
 * @property int $checked_out
 * @property float|null $total
 * @property float|null $cash
 * @property float|null $change
 * @property string|null $ref_no
 * @property int $enable_discount
 * @property string|null $discount_type
 * @property float|null $discount
 * @property string|null $discount_ref
 * @property int $enable_tip
 * @property float|null $tip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cancel[] $cancel
 * @property-read int|null $cancel_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomDish[] $customOrderDetails
 * @property-read int|null $custom_order_details_count
 * @property-read mixed $discount_option
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderDetails[] $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderReceipt[] $orderReceipts
 * @property-read int|null $order_receipts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Table[] $tables
 * @property-read int|null $tables_count
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCheckedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEnableDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEnableTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWaiterId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetails
 *
 * @property int $id
 * @property int $order_id
 * @property int $dish_id
 * @property int $printed
 * @property int $pcs
 * @property float $price_per_piece
 * @property float $price
 * @property float|null $discount
 * @property string|null $discount_no
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cancel[] $cancel
 * @property-read int|null $cancel_count
 * @property-read \App\Models\DiscountedItem|null $discountItem
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SideDish[] $sideDishes
 * @property-read int|null $side_dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails drinks()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDiscountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePricePerPiece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePrinted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereUpdatedAt($value)
 */
	class OrderDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderReceipt
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $receipt_no
 * @property string $name
 * @property string $address
 * @property string $contact
 * @property float|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereUpdatedAt($value)
 */
	class OrderReceipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SideDish
 *
 * @property int $id
 * @property int $order_details_id
 * @property int $side_dish_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\OrderDetails $order
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish query()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish whereOrderDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish whereSideDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish whereUpdatedAt($value)
 */
	class SideDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Table
 *
 * @property int $id
 * @property string $name
 * @property int $pax
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereUpdatedAt($value)
 */
	class Table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $employee_no
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $passcode
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Table[] $assignTables
 * @property-read int|null $assign_tables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cancel[] $cancelled
 * @property-read int|null $cancelled_count
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Role $role
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasscode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

