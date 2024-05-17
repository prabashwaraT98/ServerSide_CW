<?php
defined('BASEPATH') or exit('No direct script access allowed');

class answerModel extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

	public function giveAnswer($answer, $question_id, $user_id)
	{
		$data = array(
			'answer' => $answer,
			'question_id' => $question_id,
			'user_id' => $user_id
		);
		return $this->db->insert('answers', $data);
	}

	public function getAnswersByUser($user_id)
	{
		$this->db->select('answers.*, questions.title as question_title');
		$this->db->from('answers');
		$this->db->join('questions', 'answers.question_id = questions.id');
		$this->db->where('answers.user_id', $user_id);
		$result = $this->db->get()->result_array();

		if ($result === null) {
			return null;
		}
		return $result;
	}
	
	public function answerCorrect($answer_id)
	{
		$this->db->where('id', $answer_id);
		return $this->db->update('answers', array('is_correct' => 1));
	}

	public function getCorrrectAnswersByUser($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('is_correct', 1); 
		$query = $this->db->get('answers');
		return $query->result_array();
	}

	public function deleteAnswer($answer_id)
	{
		$this->db->where('id', $answer_id);
		return $this->db->delete('answers');
	}
}
