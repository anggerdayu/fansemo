<?php

class VoteController extends BaseController {

	public function likePost(){
		$id = Input::get('id');
		$likeVote = Vote::where('type','like')->where('user_id',Auth::id())->where('post_id',$id)->first();
		if(!$likeVote){
			$oppositeVote = Vote::where('type','dislike')->where('user_id',Auth::id())->where('post_id',$id)->first();
			if(!empty($oppositeVote)){
				$oppositeVote->delete();
			} 
			$vote = new Vote;
			$vote->user_id = Auth::id();
			$vote->post_id = $id;
			$vote->type = 'like';
			$vote->save();
		}
		return 'success';
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
		$oppositeVote = Vote::where('type','like')->where('user_id',Auth::id())->where('post_id',$id)->first();
		if(!empty($oppositeVote)){
			$oppositeVote->delete();
		}
		$vote = new Vote;
		$vote->user_id = Auth::id();
		$vote->post_id = $id;
		$vote->type = 'dislike';
		$vote->save();
		return 'success';
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