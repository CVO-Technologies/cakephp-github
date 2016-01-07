<?php

namespace CvoTechnologies\GitHub\Test\TestCase\Webservice;

use Cake\Network\Http\Response;
use Cake\TestSuite\TestCase;
use CvoTechnologies\GitHub\Webservice\Driver\GitHub;
use CvoTechnologies\GitHub\Webservice\GitHubWebservice;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\Query;

class GitHubWebserviceTest extends TestCase
{

    /**
     * @var GitHubWebservice
     */
    public $webservice;

    public function setUp()
    {
        parent::setUp();

        $this->webservice = new GitHubWebservice([
            'driver' => new GitHub([]),
            'endpoint' => 'repositories'
        ]);
    }

    public function testSearch()
    {
        $httpClientMock = $this->getMock('\Cake\Network\Http\Client', ['get']);
        $httpClientMock->expects($this->once())
            ->method('get')
            ->with('/repositories')
            ->will($this->returnValue(new Response([
                'HTTP/1.1 200 Ok'
            ], json_encode(array (
                0 =>
                    array (
                        'id' => 1,
                        'name' => 'repo1',
                        'full_name' => 'user1/repo1',
                        'owner' =>
                            array (
                                'login' => 'user1',
                                'id' => 1,
                                'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=3',
                                'gravatar_id' => '',
                                'url' => 'https://api.github.com/users/user1',
                                'html_url' => 'https://github.com/user1',
                                'followers_url' => 'https://api.github.com/users/user1/followers',
                                'following_url' => 'https://api.github.com/users/user1/following{/other_user}',
                                'gists_url' => 'https://api.github.com/users/user1/gists{/gist_id}',
                                'starred_url' => 'https://api.github.com/users/user1/starred{/owner}{/repo}',
                                'subscriptions_url' => 'https://api.github.com/users/user1/subscriptions',
                                'organizations_url' => 'https://api.github.com/users/user1/orgs',
                                'repos_url' => 'https://api.github.com/users/user1/repos',
                                'events_url' => 'https://api.github.com/users/user1/events{/privacy}',
                                'received_events_url' => 'https://api.github.com/users/user1/received_events',
                                'type' => 'User',
                                'site_admin' => false,
                            ),
                        'private' => false,
                        'html_url' => 'https://github.com/user1/repo1',
                        'description' => 'Repo 1',
                        'fork' => false,
                        'url' => 'https://api.github.com/repos/user1/repo1',
                        'forks_url' => 'https://api.github.com/repos/user1/repo1/forks',
                        'keys_url' => 'https://api.github.com/repos/user1/repo1/keys{/key_id}',
                        'collaborators_url' => 'https://api.github.com/repos/user1/repo1/collaborators{/collaborator}',
                        'teams_url' => 'https://api.github.com/repos/user1/repo1/teams',
                        'hooks_url' => 'https://api.github.com/repos/user1/repo1/hooks',
                        'issue_events_url' => 'https://api.github.com/repos/user1/repo1/issues/events{/number}',
                        'events_url' => 'https://api.github.com/repos/user1/repo1/events',
                        'assignees_url' => 'https://api.github.com/repos/user1/repo1/assignees{/user}',
                        'branches_url' => 'https://api.github.com/repos/user1/repo1/branches{/branch}',
                        'tags_url' => 'https://api.github.com/repos/user1/repo1/tags',
                        'blobs_url' => 'https://api.github.com/repos/user1/repo1/git/blobs{/sha}',
                        'git_tags_url' => 'https://api.github.com/repos/user1/repo1/git/tags{/sha}',
                        'git_refs_url' => 'https://api.github.com/repos/user1/repo1/git/refs{/sha}',
                        'trees_url' => 'https://api.github.com/repos/user1/repo1/git/trees{/sha}',
                        'statuses_url' => 'https://api.github.com/repos/user1/repo1/statuses/{sha}',
                        'languages_url' => 'https://api.github.com/repos/user1/repo1/languages',
                        'stargazers_url' => 'https://api.github.com/repos/user1/repo1/stargazers',
                        'contributors_url' => 'https://api.github.com/repos/user1/repo1/contributors',
                        'subscribers_url' => 'https://api.github.com/repos/user1/repo1/subscribers',
                        'subscription_url' => 'https://api.github.com/repos/user1/repo1/subscription',
                        'commits_url' => 'https://api.github.com/repos/user1/repo1/commits{/sha}',
                        'git_commits_url' => 'https://api.github.com/repos/user1/repo1/git/commits{/sha}',
                        'comments_url' => 'https://api.github.com/repos/user1/repo1/comments{/number}',
                        'issue_comment_url' => 'https://api.github.com/repos/user1/repo1/issues/comments{/number}',
                        'contents_url' => 'https://api.github.com/repos/user1/repo1/contents/{+path}',
                        'compare_url' => 'https://api.github.com/repos/user1/repo1/compare/{base}...{head}',
                        'merges_url' => 'https://api.github.com/repos/user1/repo1/merges',
                        'archive_url' => 'https://api.github.com/repos/user1/repo1/{archive_format}{/ref}',
                        'downloads_url' => 'https://api.github.com/repos/user1/repo1/downloads',
                        'issues_url' => 'https://api.github.com/repos/user1/repo1/issues{/number}',
                        'pulls_url' => 'https://api.github.com/repos/user1/repo1/pulls{/number}',
                        'milestones_url' => 'https://api.github.com/repos/user1/repo1/milestones{/number}',
                        'notifications_url' => 'https://api.github.com/repos/user1/repo1/notifications{?since,all,participating}',
                        'labels_url' => 'https://api.github.com/repos/user1/repo1/labels{/name}',
                        'releases_url' => 'https://api.github.com/repos/user1/repo1/releases{/id}',
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'name' => 'repo1',
                        'full_name' => 'user2/repo1',
                        'owner' =>
                            array (
                                'login' => 'user2',
                                'id' => 2,
                                'avatar_url' => 'https://avatars.githubusercontent.com/u/4?v=3',
                                'gravatar_id' => '',
                                'url' => 'https://api.github.com/users/user2',
                                'html_url' => 'https://github.com/user2',
                                'followers_url' => 'https://api.github.com/users/user2/followers',
                                'following_url' => 'https://api.github.com/users/user2/following{/other_user}',
                                'gists_url' => 'https://api.github.com/users/user2/gists{/gist_id}',
                                'starred_url' => 'https://api.github.com/users/user2/starred{/owner}{/repo}',
                                'subscriptions_url' => 'https://api.github.com/users/user2/subscriptions',
                                'organizations_url' => 'https://api.github.com/users/user2/orgs',
                                'repos_url' => 'https://api.github.com/users/user2/repos',
                                'events_url' => 'https://api.github.com/users/user2/events{/privacy}',
                                'received_events_url' => 'https://api.github.com/users/user2/received_events',
                                'type' => 'User',
                                'site_admin' => false,
                            ),
                        'private' => false,
                        'html_url' => 'https://github.com/user2/repo1',
                        'description' => 'Repo 1',
                        'fork' => false,
                        'url' => 'https://api.github.com/repos/user2/repo1',
                        'forks_url' => 'https://api.github.com/repos/user2/repo1/forks',
                        'keys_url' => 'https://api.github.com/repos/user2/repo1/keys{/key_id}',
                        'collaborators_url' => 'https://api.github.com/repos/user2/repo1/collaborators{/collaborator}',
                        'teams_url' => 'https://api.github.com/repos/user2/repo1/teams',
                        'hooks_url' => 'https://api.github.com/repos/user2/repo1/hooks',
                        'issue_events_url' => 'https://api.github.com/repos/user2/repo1/issues/events{/number}',
                        'events_url' => 'https://api.github.com/repos/user2/repo1/events',
                        'assignees_url' => 'https://api.github.com/repos/user2/repo1/assignees{/user}',
                        'branches_url' => 'https://api.github.com/repos/user2/repo1/branches{/branch}',
                        'tags_url' => 'https://api.github.com/repos/user2/repo1/tags',
                        'blobs_url' => 'https://api.github.com/repos/user2/repo1/git/blobs{/sha}',
                        'git_tags_url' => 'https://api.github.com/repos/user2/repo1/git/tags{/sha}',
                        'git_refs_url' => 'https://api.github.com/repos/user2/repo1/git/refs{/sha}',
                        'trees_url' => 'https://api.github.com/repos/user2/repo1/git/trees{/sha}',
                        'statuses_url' => 'https://api.github.com/repos/user2/repo1/statuses/{sha}',
                        'languages_url' => 'https://api.github.com/repos/user2/repo1/languages',
                        'stargazers_url' => 'https://api.github.com/repos/user2/repo1/stargazers',
                        'contributors_url' => 'https://api.github.com/repos/user2/repo1/contributors',
                        'subscribers_url' => 'https://api.github.com/repos/user2/repo1/subscribers',
                        'subscription_url' => 'https://api.github.com/repos/user2/repo1/subscription',
                        'commits_url' => 'https://api.github.com/repos/user2/repo1/commits{/sha}',
                        'git_commits_url' => 'https://api.github.com/repos/user2/repo1/git/commits{/sha}',
                        'comments_url' => 'https://api.github.com/repos/user2/repo1/comments{/number}',
                        'issue_comment_url' => 'https://api.github.com/repos/user2/repo1/issues/comments{/number}',
                        'contents_url' => 'https://api.github.com/repos/user2/repo1/contents/{+path}',
                        'compare_url' => 'https://api.github.com/repos/user2/repo1/compare/{base}...{head}',
                        'merges_url' => 'https://api.github.com/repos/user2/repo1/merges',
                        'archive_url' => 'https://api.github.com/repos/user2/repo1/{archive_format}{/ref}',
                        'downloads_url' => 'https://api.github.com/repos/user2/repo1/downloads',
                        'issues_url' => 'https://api.github.com/repos/user2/repo1/issues{/number}',
                        'pulls_url' => 'https://api.github.com/repos/user2/repo1/pulls{/number}',
                        'milestones_url' => 'https://api.github.com/repos/user2/repo1/milestones{/number}',
                        'notifications_url' => 'https://api.github.com/repos/user2/repo1/notifications{?since,all,participating}',
                        'labels_url' => 'https://api.github.com/repos/user2/repo1/labels{/name}',
                        'releases_url' => 'https://api.github.com/repos/user2/repo1/releases{/id}',
                    )
            )))));

        $this->webservice->driver()->client($httpClientMock);

        $query = new Query($this->webservice, new Endpoint());
        $query->read();

        $resultSet = $this->webservice->execute($query, [
            'resourceClass' => '\Muffin\Webservice\Model\Resource'
        ]);
        $this->assertInstanceOf('\Muffin\Webservice\ResultSet', $resultSet);
        $this->assertEquals(2, $resultSet->count());
    }
}
