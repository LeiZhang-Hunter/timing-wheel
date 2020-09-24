#include <iostream>
#include <functional>
#include <unordered_set>
#include <boost/circular_buffer.hpp>

struct WheelTimerNode;
using WheelTimerCallback = std::function<void(WheelTimerNode *)>;

class Socket {
public:
    Socket() {

    }

    void close() {
        std::cout << "time out" << std::endl;
        std::cout << "close" << std::endl;
    }

    ~Socket() {

    }
};

struct WheelTimerNode {
public:
    WheelTimerNode() {

    }

    class Socket socket;

    ~WheelTimerNode() {
        socket.close();
    }

    WheelTimerCallback callback_;
};

class WheelTimer {
public:
    WheelTimer() {

    }

    typedef std::unordered_set<std::shared_ptr<WheelTimerNode>> bucket_;
    typedef boost::circular_buffer<bucket_> buckets_;
    buckets_ buckets;

    //定义轮盘大小
    void resize(int size) {
        buckets.resize(size);
    }

    //插入socket节点
    void add(std::shared_ptr<WheelTimerNode> &node) {
        buckets.back().insert(node);
    }

    //推动轮盘
    void move() {
        buckets.push_back(bucket_());
    }

    ~WheelTimer() {

    }

private:
};

/**
 * 用在项目中要用一个定时任务(epoll+timerfd) 去 定时推动轮盘
 *  wheel->move()
 * @return
 */
int main() {
    std::unique_ptr<WheelTimer> wheel(new WheelTimer);
    //定义时间轮刻度是5
    wheel->resize(5);
    std::shared_ptr<WheelTimerNode> socketNode = std::make_shared<WheelTimerNode>();
    wheel->add(socketNode);
    wheel->move();
    wheel->add(socketNode);
    wheel->move();
    wheel->move();
    wheel->move();
    wheel->move();
    wheel->move();
    wheel->move();
    return 0;
}
