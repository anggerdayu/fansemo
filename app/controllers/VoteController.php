<?php

class VoteController extends BaseController {

	public function likePost(){
		$id = Input::get('id');
		$likeVote = Vote::where('type','like')->where('user_id',Auth::id())->where('post_id',$id)->first();
		if(!$likeVote || Auth::user()->status == 'management'){
			$oppositeVote = Vote::where('type','dislike')->where('user_id',Auth::id())->where('post_id',$id)->first();
			if(!empty($oppositeVote) && Auth::user()->status != 'management'){
				$oppositeVote->delete();
			} 
			$vote = new Vote;
			$vote->user_id = Auth::id();
			$vote->post_id = $id;
			$vote->type = 'like';
			$vote->save();
		}
		$totalLikeVote = Vote::where('type','like')->where('post_id',$id)->count();
		$totalDislikeVote = Vote::where('type','dislike')->where('post_id',$id)->count();
		$result = array($totalLikeVote, $totalDislikeVote);
		return Response::json($result);
	}

	public function likeCommentPost(){
		$id = Input::get('id');
		
		$oppositeVote = CommentVote::where('type','dislike')->where('user_id',Auth::id())->where('comment_id',$id)->first();
		if(!empty($oppositeVote)){
			$oppositeVote->delete();
		} 
		$vote = new CommentVote;
		$vote->user_id = Auth::id();
		$vote->comment_id = $id;
		$vote->type = 'like';
		$vote->save();
		return 'success';
	}

	public function dislikePost(){
		$id = Input::get('id');
		$dislikeVote = Vote::where('type','dislike')->where('user_id',Auth::id())->where('post_id',$id)->first();
		if(!$dislikeVote || Auth::user()->status == 'management'){
			$oppositeVote = Vote::where('type','like')->where('user_id',Auth::id())->where('post_id',$id)->first();
			if(!empty($oppositeVote) && Auth::user()->status != 'management'){
				$oppositeVote->delete();
			}
			$vote = new Vote;
			$vote->user_id = Auth::id();
			$vote->post_id = $id;
			$vote->type = 'dislike';
			$vote->save();
		}
		$totalLikeVote = Vote::where('type','like')->where('post_id',$id)->count();
		$totalDislikeVote = Vote::where('type','dislike')->where('post_id',$id)->count();
		$result = array($totalLikeVote, $totalDislikeVote);
		return Response::json($result);
	}

	public function dislikeCommentPost(){
		$id = Input::get('id');
		$oppositeVote = CommentVote::where('type','like')->where('user_id',Auth::id())->where('comment_id',$id)->first();
		if(!empty($oppositeVote)){
			$oppositeVote->delete();
		}
		$vote = new CommentVote;
		$vote->user_id = Auth::id();
		$vote->comment_id = $id;
		$vote->type = 'dislike';
		$vote->save();
		return 'success';
	}
}