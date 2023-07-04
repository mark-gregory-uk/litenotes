<?php

namespace App\Http\Controllers;

    use App\Http\Controllers\Api\ApiController;
    use App\Models\DataFeed;
    use Illuminate\Http\Request;

    class DataFeedController extends ApiController
    {
        /**
         * @return mixed
         */
        public function getDataFeed(Request $request)
        {
            $df = new DataFeed();

            return (object) [
                'labels' => $df->getDataFeed(
                    $request->datatype,
                    'label',
                    $request->limit
                ),
                'data' => $df->getDataFeed(
                    $request->datatype,
                    'data',
                    $request->limit
                ),
            ];
        }
    }
