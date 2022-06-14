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
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $cancellable
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel query()
 */
	class Cancel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dish[] $dishes
 * @property-read int|null $dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Configuration
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 */
	class Configuration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomDish
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cancel[] $cancel
 * @property-read int|null $cancel_count
 * @property-read \App\Models\DiscountedItem|null $discountItem
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish query()
 */
	class CustomDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiscountedItem
 *
 * @property-read \App\Models\Discount $discountType
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $discountable
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem query()
 */
	class DiscountedItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dish
 *
 * @property-read \App\Models\Category $category
 * @property-read mixed $price_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|Dish active()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish sideDish()
 */
	class Dish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
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
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetails
 *
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
 */
	class OrderDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderReceipt
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt query()
 */
	class OrderReceipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Database\Factories\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SideDish
 *
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\OrderDetails $order
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish query()
 */
	class SideDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Table
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 */
	class Table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
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
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

