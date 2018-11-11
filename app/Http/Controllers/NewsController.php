<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Enroll;
use App\Models\Join;
use App\Models\Shequ;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    protected function newslist(Request $request){
    	$news = new News;
    	if(!$request->input('mun')){
    		$mun = '5';
    	}else{
    		$mun = $request->input('mun');
    	}
    	if($request->input('cat')){
             $nwes = $news->where('cat',$request->input('cat'));
    	}
        $data = $news->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->paginate($mun);
        return $data;
    }

    protected function onenew(Request $request){
    	if($request->input('id')){
    		$data = News::find($request->input('id'));
    		if($data){
    			return ['message'=>'ok', 'data'=>$data];
    		}else{
    			return ['message'=>'fail', 'data'=>'没有改文章'];
    		}
    	}else{
            return ['message'=>'fail', 'data'=>'暂无内容'];
    	}
    }

    protected function baoming(Request $request){
        $enroll = new Enroll;
        $data = [
          'name' => $request->input('name'),
          'sex' => $request->input('sex'),
          'age' => $request->input('age'),
          'tel' => $request->input('tel'),
          'area' => $request->input('where')
        ];
        if(!empty($data['name'])){
	        $enroll->name = e($data['name']);
	        $enroll->sex  = e($data['sex']);
	        $enroll->age  = e($data['age']);
	        $enroll->tel  = e($data['tel']);
            $enroll->area  = e($data['area']);
	        if($enroll->save()){
	        	return ['message'=>'ok','data'=>'提交成功，客服将会马上与您联系安排课程！'];
	        }else{
	        	return ['message'=>'fail','data'=>'提交失败'];
	        }
        }else{
        	return ['message'=>'fail','data'=>'内容为空'];
        }
    }

    protected function zs(Request $request){
        $join = new Join;
        $data = [
          'name' => $request->input('name'),
          'tel' => $request->input('tel'),
          'type' => $request->input('type'),
          'where' => $request->input('where')
        ];
        if(!empty($data['name'])){
            $join->name = e($data['name']);
            $join->tel  = e($data['tel']);
            $join->where  = e($data['where']);
            $join->type  = e($data['type']);
            if($join->save()){
                return ['message'=>'ok','data'=>'提交成功，工作人员将会马上与您联系！'];
            }else{
                return ['message'=>'fail','data'=>'提交失败'];
            }
        }else{
            return ['message'=>'fail','data'=>'内容为空'];
        }
    }

    protected function shequ(Request $request){
        $join = new Shequ;
        $data = [
          'name' => $request->input('name'),
          'tel' => $request->input('tel'),
          'area' => $request->input('area'),
          'job' => $request->input('job')
        ];
        if(!empty($data['name'])){
            $join->name = e($data['name']);
            $join->tel  = e($data['tel']);
            $join->area  = e($data['area']);
            $join->job  = e($data['job']);
            if($join->save()){
                return ['message'=>'ok','data'=>'提交成功，工作人员将会马上与您联系！'];
            }else{
                return ['message'=>'fail','data'=>'提交失败'];
            }
        }else{
            return ['message'=>'fail','data'=>'内容为空'];
        }
    }

}
