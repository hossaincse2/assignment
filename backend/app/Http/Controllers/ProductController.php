<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Image;

class ProductController extends Controller
{
    protected $productRepo;
    public function __construct(ProductInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Product';
        return view('product.add',['title' => $title,'data' => new Product()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();

             if ($request->file('image')){
                 $image_name = $this->imageUpload($request->file('image'));
             }else {
                 $image_name = $request->get('old_image');
             }
            $product = new Product($data);
            if ($request->get('product_id')) {
                $product->exists =  true;
                $product->id =  $request->get('product_id');
                $product->image =  $image_name;
                $product->save();
                return redirect()->route('product.list')
                    ->with('success','Product updated successfully.');
            }else{
                $product->image =  $image_name;
                $product->save();
                return redirect()->route('product.list')
                    ->with('success','Product created successfully.');
            }


        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return redirect()->route('product.list')
                ->with('error','Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepo->findProduct($id);
        $title = 'Edit Product';
        return view('product.add',['data' => $product,'title' => $title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::find($id);
        $product->delete();

        return redirect()->route('product.list')
            ->with('success','Product deleted successfully.');
    }

    public function imageUpload($image)
    {
        $input['imagename'] = time().'.'.$image->extension();

        $filePath = public_path('/products/thumbnails');

        $img = Image::make($image->path());
        $img->resize(110, 110, function ($const) {
            $const->aspectRatio();
        })->save($filePath.'/'.$input['imagename']);

        $filePath = public_path('/products');
        $image->move($filePath, $input['imagename']);
        return $input['imagename'];
     }

    public function baseUrl($image= null ,$img_type = 'original')
    {
        header('Content-Type: image/png');
        header('Content-Type: image/jpeg');
        header('Content-Type: image/gif');
        $basePathNoImage = public_path() . '/products/no-img.png';
        try {
            if ($img_type == 'original') {
                $basePathOriginal = public_path() . '/products/' . $image;
                readfile($basePathOriginal);
            } else if ($img_type == 'thumbnail') {
                $basePathThumbnail = public_path() . '/products/thumbnails/' . $image;
                readfile($basePathThumbnail);
            } else {
                readfile($basePathNoImage);
            }
        } catch (\Exception  $e) {
            //dd($e->getMessage());
            readfile($basePathNoImage);
        }

    }
    public function datatableList(Request $request)
    {
        $queryResult = $this->productRepo->findProduct();
        return datatables()->of($queryResult)
            ->addColumn('date', function($query) {
                return date('d-m-Y',strtotime($query->created_at));
            })
            ->addColumn('product_image', function($query) {
                    $html = ' <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div
                                    class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                                >
                                    <img
                                        class="object-cover w-full h-full rounded-full"
                                        src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                                        alt=""
                                        loading="lazy"
                                    />
                                    <div
                                        class="absolute inset-0 rounded-full shadow-inner"
                                        aria-hidden="true"
                                    ></div>
                                </div>
                                <div>
                                    <p class="font-semibold">Hans Burger</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        10x Developer
                                    </p>
                                </div>
                            </div>';

                    return $html;
            })
            ->addColumn('action', function($query) {
                return '<div class="flex items-center space-x-4 text-sm">
                                <a
                                    href="'. route('product.edit', $query->id) .'"
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        ></path>
                                    </svg>
                                </a>
                                <a
                                    href="'. route('product.destroy', $query->id) .'"
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </a>
                            </div>';
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }
}
