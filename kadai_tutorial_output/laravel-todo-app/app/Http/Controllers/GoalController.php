<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //一覧ページを表示
    {
        $goals = Auth::user()->goals;
        $tags = Auth::user()->tags;

        return view('goals.index', compact('goals', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //作成機能 requestクラスを使ってフォームから送信された入力内容を取得する
    {
        $request->validate([ //バリデーションを設定し、フォームに値が入力されているかどうかチェックする
            'title' => 'required',
        ]);

        $goal = new Goal(); //goalモデルをインスタンス化して新しいデータを作成する
        $goal->title = $request->input('title'); //フォームから送信された入力内容をtitleカラムに代入する
        $goal->user_id = Auth::id(); //現在ログイン中のユーザーのIDをuser_idカラムに代入する
        $goal->save(); //goalsテーブルにデータを保存する

        return redirect()->route('goals.index'); //トップページにリダイレクトさせる
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal) //更新機能　どのデータを更新するかという情報がいつ用なのでgoalモデルのインスタンスを受け取る
    {
        $request->validate([ //バリデーションを設定する
            'title' => 'required',
        ]);

        $goal->title = $request->input('title'); //フォームから送信された入力内容を代入
        $goal->user_id = Auth::id(); //現在ログイン中のユーザーのIDを代入
        $goal->save(); //goalsテーブルにデータを保存

        return redirect()->route('goals.index'); //トップページにリダイレクト
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal) //削除機能
    {
        $goal->delete();

        return redirect()->route('goals.index');
    }
}
