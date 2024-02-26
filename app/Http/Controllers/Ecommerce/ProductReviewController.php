<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ProductReviewRequest;

use App\Models\Ecommerce\{
    ProductReview
};

class ProductReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request)
    {
        $newData = $request->validated();

        $newData['product_id'] = $request->product_id;
        $newData['user_id'] = $request->user_id;
        $newData['name'] = $request->name;
        $newData['email'] = $request->email;
        $newData['comment'] = $request->comment;
        $newData['rating'] = $request->rating;

        ProductReview::create($newData);

        return redirect()->back()->with('success', 'Successfully added a review');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product_review = ProductReview::findOrFail($id);

        $updateData['comment'] = $request->comment;

        $product_review->update($updateData);

        return redirect()->back()->with('success', 'Successfully edited a review');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
